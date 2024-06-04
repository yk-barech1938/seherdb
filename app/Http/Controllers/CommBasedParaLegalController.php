<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator; 
use App\Exports\ParticipantLPSExport;
use Illuminate\Support\Facades\Auth;
use App\Models\CommBasedParaLegal;
use App\Models\ParticipantLPS;
use Illuminate\Http\Request;
use App\Models\Activities;
use App\Models\District;
use App\Models\Camp;
use Carbon\Carbon;
use Excel;
use DB;

class CommBasedParaLegalController extends Controller
{
    public function index()
    {
        // $awarenessSessions = DB::table('comm_based_para_legals')
        //                     ->join('genders', 'genders.id', '=', 'comm_based_para_legals.gender_id')
        //                     ->join('districts', 'districts.id', '=', 'comm_based_para_legals.district_id')
        //                     ->get();
        // $genders = DB::table('genders')->get();
        // $districts = DB::table('districts')->get();
        if (Auth::check()) {
            $user = Auth::user(); 
            $districtId = $user->district_id; 
            $camps = DB::table('camps')->get();
        }
        $countMale = ParticipantLPS::where('gender_id', '1')->where('code', 'CBPL')->count();
        $countFemale = ParticipantLPS::where('gender_id', '2')->where('code', 'CBPL')->count();
        $total = $countMale + $countFemale;
         // Count records where nationality starts with "P"
         $countHostMale = ParticipantLPS::where('nationality', 'LIKE', 'P%')->where('gender_id', '1')->where('code', 'CBPL')
         ->count();
         $countHostFemale = ParticipantLPS::where('nationality', 'LIKE', 'P%')->where('gender_id', '2')->where('code', 'CBPL') 
         ->count();
         // Count records where nationality starts with "A"
         $countRefugeesMale = ParticipantLPS::where('nationality', 'LIKE', 'A%')->where('gender_id', '1')->where('code', 'CBPL') 
         ->count();
          // Count records where nationality starts with "A"
          $countRefugeesFemale = ParticipantLPS::where('nationality', 'LIKE', 'A%')->where('gender_id', '2')->where('code', 'CBPL') 
          ->count();
        $totalHost = $countHostMale + $countHostFemale;
        $totalRefugees = $countRefugeesMale + $countRefugeesFemale;
        $countActivity = Activities::where('title', 'like', 'CBPL%')->count();
        $districts = District::all();
        return view('employee.cbpl.cbpl-activity',compact('countActivity', 'camps','countMale','countFemale','countHostMale','countHostFemale','countRefugeesMale','countRefugeesFemale','total','totalHost','totalRefugees','districts'));
    }
    // Storing CBPL Activity:  Copied from Awareness Session
    public function store(Request $request)
    {
        try 
        {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240', // Image validation rules
                'pdfs.*' => 'mimes:pdf|max:10240', // PDF validation rules
                'movsCheckBox' => 'required|array',
                'camp' => 'required',
                'district' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
              
            $id = Auth::id();
            $user = DB::table('users')->find($id);
            $dist_id = $user->district_id;
            $camp = $request->input('camp');
            if ($camp == 'other') {
                $otherCamp = $request->input('otherCamp');
                $newCamp = new Camp();
                $newCamp->title = $otherCamp;
                $newCamp->district_id = $request->input('district'); // Assign district_id here
                $newCamp->save();
                $newCampId = $newCamp->id;
                // Create a new activity for Other camp
                $activity = Activities::create([
                        'title' =>"CBPL",
                        'district_id' => $request->input('district'),
                        'user_id' => $id,
                        'movs_name' => json_encode($request->movsCheckBox), // Store as JSON
                        'date' => $request->input('date'),
                        'camp_id' => $newCampId, // Assuming 'camp' is the name of the select field

                ]);
            }
            else{
                    // Create a new activity
                    $activity = Activities::create([
                        'title' =>"CBPL",
                        'district_id' => $request->input('district'),
                        'user_id' => $id,
                        'movs_name' => json_encode($request->movsCheckBox), // Store as JSON
                        'date' => $request->input('date'),
                        'camp_id' => $request->input('camp'), // Assuming 'camp' is the name of the select field

                    ]);
            }
            // Handle image uploads for 'images[]'
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->storeAs('images', $imageName);

                    // Create image record in the database
                    $activity->images()->create([
                        'title' => $imageName,
                    ]);
                }
            }
            // Handle PDF uploads for 'pdfs[]'
            if ($request->hasFile('pdfs')) {
                foreach ($request->file('pdfs') as $pdf) {
                    $pdfName = time() . '_' . $pdf->getClientOriginalName();
                    $pdf->storeAs('pdfs', $pdfName);

                    // Create PDF record in the database or handle as needed
                    // Example: save PDF filename to a column in the activity table
                    $activity->images()->create([
                        'title' => $pdfName,
                    ]);
                }
            }
                    // Handle image uploads for 'optional_images[]'
            if ($request->hasFile('optional_images')) {
                foreach ($request->file('optional_images') as $optionalImage) {
                    $optionalImageName = time() . '_optional_' . $optionalImage->getClientOriginalName();
                    $optionalImage->storeAs('images', $optionalImageName);

                    // Create optional image record in the database
                    $activity->optionalImages()->create([
                        'title' => $optionalImageName,
                    ]);
                }
            }

                // Return success response with additional data
                return response()->json(['success' => true, 'message' => 'Data added successfully']);

        } catch (ValidationException $e) {
            // Handle validation errors
            $errors = $e->validator->errors()->all();

            return response()->json(['error' => $errors], 422);
        } catch (\Exception $e) {
            // Log the exception details for debugging
            \Log::error('Error in store method: ' . $e->getMessage() . "\n" . $e->getTraceAsString());

            // Return a generic error response
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }


    // get all CBPL ajax request Table Data
    public function fetchAllCBPLs()
    {
        $cbpls = CommBasedParaLegal::all();
        
        $output = '';
        if($cbpls->count()>0){
            $output .= '<table class="table table-striped table-bordered" style="width:100%; font-size: small;" id="dataTableExample">
            <thead style="background-color: #6571ff;">
              <tr>
                <th style="color: white;">Name</th>
                <th style="color: white;">Father</th>
                <th style="color: white;">Gender</th>
                <th style="color: white;">Document</th>
                <th style="color: white;">District</th>
                <th style="color: white;">Camp</th>
                <th style="color: white;">Conducted</th>
                <th style="color: white;">Session</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($cbpls as $cbpl) {
				$output .= '<tr>
                <td>' . $cbpl->name .'</td>
                <td>' . $cbpl->father.'</td>
                <td>' . $cbpl->gender->gender . '</td>
                <td>' . $cbpl->document_no . '</td>
                <td>' . $cbpl->district->district . '</td>
                <td>' . $cbpl->camp . '</td>
                <td>' . $cbpl->conducted . '</td>
                <td data-sort="' . \Carbon\Carbon::parse($cbpl->session_date)->format('Y-m-d') . '">
            ' . \Carbon\Carbon::parse($cbpl->session_date)->format('d-m-Y') . '
                </td>
                </tr>';
            }
            $output .= '</tbody></table>';
			echo $output;
        } else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }
    // get all CBPL Activites ajax request Table Data
    public function fetchAllCBPL()
    {
        $userId = Auth::id();
        $userRoleId = Auth::user()->role_id;
        if ($userRoleId == 2) {
            $activities = Activities::where('title', 'like', 'CBPL%')
            ->select('id','title', 'district_id', 'user_id', 'date', 'movs_name', 'camp_id')
            ->get();
            
        } else {
            // Retrieve activities based on the authenticated user's ID
            $activities = Activities::where('user_id', $userId)->where('title', 'like', 'CBPL%')->select('id','title', 'district_id', 'user_id', 'date', 'movs_name', 'camp_id')->get();
        }
        $output = '';
        if($activities->count()>0){
            $output .= ' <table id="dataTableExample" class="table table-striped table-bordered" style="width:100%; font-size: small;">
            <thead style="background-color: #6571ff;">
              <tr>
                <th style="color: #f8f8ff;">Name</th>
                <th style="color: #f8f8ff;">Date</th>
                <th style="color: #f8f8ff;">District</th>
                <th style="color: #f8f8ff;">Camp</th>
                <th style="color: #f8f8ff;">Conducted</th>
                <th style="color: #f8f8ff;">Check</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($activities as $activity) {
                $attendanceIcons = '<i class="fas fa-user-check fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Attendance Not Uploaded!"></i>';
                $pictureIcons = '<i class="fas fa-image fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Pictures Not Uploaded!"></i>';
                $reportIcons = '<i class="fas fa-file-alt fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Report Not Uploaded!"</i>';
                // $movs_checkedValue = $activity->movs_name ? implode(', ', json_decode($activity->movs_name)) : '';
                $movs_checkedValue = $activity->movs_name ? json_decode($activity->movs_name) : [];
                    if (in_array("Attendance", $movs_checkedValue)) {
                        $attendanceIcons = '<i class="fas fa-user-check fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"></i>';
                    }
                    if (in_array("Pictures", $movs_checkedValue)) {
                        $pictureIcons = '<i class="fas fa-image fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"></i>';
                    }
                    if (in_array("Report", $movs_checkedValue)) {
                        $reportIcons = '<i class="fas fa-file-alt fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"</i>';
                    }
                    $combinedIconss = $attendanceIcons .' '. $pictureIcons .' '. $reportIcons;
             
            
				$output .= '<tr>
                <td><a href="' . route('view-cbpl-activity', ['id' => $activity->id]) . '" target="_self" class="activity-link">
                <i class="fas fa-hand-point-right fa-lg" style="margin-right: 5px;"></i>&nbsp;' . $activity->title . '
                    </a></td>
  
                <td data-sort="' . \Carbon\Carbon::parse($activity->date)->format('Y-m-d') . '">
                ' . \Carbon\Carbon::parse($activity->date)->format('d-m-Y') . '
                    </td>
                <td>' . $activity->district->district. '</td>
                <td>' . $activity->camp->title. '</td>
                <td>' . $activity->username->name . '</td>
                <td style="width: 100px;">' . $combinedIconss . '</td>
                </tr>';
                $combinedIconss="";
            }
            $output .= '</tbody></table>';
			echo $output;
        } else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the CBPL!</h1>';
        }
    }
    // Get search by Date Range Filter CBPL Activities
    public function searchCbplActivities(Request $request) 
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        // getting the role_id then will shows the data according to that.
        $id = Auth::user()->id;
        $roleId = Auth::user()->role_id;
        if ($roleId == 1) 
        {
            // incase of 1 get the data according to the current user only 
            // $activities = DB::table('activities')
            // ->join('districts', 'districts.id', '=', 'activities.district_id')
            // ->join('camps', 'camps.id', '=', 'activities.camp_id')
            // ->join('users', 'users.id', '=', 'activities.user_id')
            // ->select('activities.*', 'districts.district','camps.title as camp','users.name')
            // ->where('activities.date', '>=', $fromDate)
            // ->where('activities.date', '<=', $toDate)
            // ->where('activities.user_id', $id)
            // ->get();
            $activities = Activities::whereDate('date', '>=', $fromDate)
                        ->whereDate('date', '<=', $toDate)
                        ->where('user_id', $id)->where('title', 'CBPL')
                        ->get();
        } 
        elseif ($roleId == 2) 
        {
            // for agent based to deal with the data getting all the awareness session
            // $activities = DB::table('activities')
            // ->join('districts', 'districts.id', '=', 'activities.district_id')
            // ->join('camps', 'camps.id', '=', 'activities.camp_id')
            // ->join('users', 'users.id', '=', 'activities.user_id')
            // ->select('activities.*', 'districts.district','camps.title as camp','users.name')
            // ->where('activities.date', '>=', $fromDate)
            // ->where('activities.date', '<=', $toDate)
            // ->get();
            $activities = Activities::whereDate('date', '>=', $fromDate)
                        ->whereDate('date', '<=', $toDate)->where('title', 'CBPL')
                        ->get();
        } else {
            // Handle other cases, if needed
            \Log::info('data is not shown for Both Role_id: 1/2.');
            \Log::info('Help?. Use Complaint Controller StoreLps Logs method you will reach to the problem.');
        }

        $output = '';
        if ($activities->count() > 0) {
            $output .= '<table id="dataTableExample" class="table table-striped table-bordered" style="width:100%; font-size: small;">
                <thead style="background-color: #6571ff;">
                    <tr>
                        <th style="color: #f8f8ff;">Name</th>
                        <th style="color: #f8f8ff;">Date</th>
                        <th style="color: #f8f8ff;">District</th>
                        <th style="color: #f8f8ff;">Camp</th>
                        <th style="color: #f8f8ff;">Conducted</th>
                        <th style="color: #f8f8ff;">Check</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($activities as $activity) {
                $attendanceIcon = '<i class="fas fa-user-check fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Attendance Not Uploaded!"></i>';
                $pictureIcon = '<i class="fas fa-image fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Pictures Not Uploaded!"></i>';
                $reportIcon = '<i class="fas fa-file-alt fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Report Not Uploaded!"</i>';
        
                $movs_checkedValue = $activity->movs_name ? json_decode($activity->movs_name) : [];
                if (in_array("Attendance", $movs_checkedValue)) {
                    $attendanceIcon = '<i class="fas fa-user-check fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"></i>';
                }
                if (in_array("Pictures", $movs_checkedValue)) {
                    $pictureIcon = '<i class="fas fa-image fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"></i>';
                }
                if (in_array("Report", $movs_checkedValue)) {
                    $reportIcon = '<i class="fas fa-file-alt fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"</i>';
                }
                $combinedIcons = $attendanceIcon .' '. $pictureIcon .' '. $reportIcon;
        
                $output .= '<tr>
                    <td><a href="' . route('view-cbpl-activity', ['id' => $activity->id]) . '" target="_self" class="activity-link">
                    <i class="fas fa-hand-point-right fa-lg" style="margin-right: 5px;"></i>&nbsp;' . $activity->title . '
                        </a></td>
                    <td data-sort="' . \Carbon\Carbon::parse($activity->date)->format('Y-m-d') . '">' . \Carbon\Carbon::parse($activity->date)->format('d-m-Y') . '</td>
                    <td>' . $activity->district->district. '</td>
                    <td>' . $activity->camp->title. '</td>
                    <td>' . $activity->username->name . '</td>
                    <td style="width: 100px;">' . $combinedIcons . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No records present in the database for this district!</h1>';
        }
    }
        // get Awareness Session Activities ajax request Table Data based on district
    public function fetchCbplByDistrict($selectedDistrictId)
    {
        $activities = Activities::where('district_id', $selectedDistrictId)->where('title', 'CBPL')->get();
        $output = '';
        if ($activities->count() > 0) {
            $output .= '<table id="dataTableExample" class="table table-striped table-bordered" style="width:100%; font-size: small;">
                <thead style="background-color: #6571ff;">
                    <tr>
                        <th style="color: #f8f8ff;">Name</th>
                        <th style="color: #f8f8ff;">Date</th>
                        <th style="color: #f8f8ff;">District</th>
                        <th style="color: #f8f8ff;">Camp</th>
                        <th style="color: #f8f8ff;">Conducted</th>
                        <th style="color: #f8f8ff;">Check</th>
                    </tr>
                </thead>
                <tbody>';
            foreach ($activities as $activity) {
                $attendanceIcon = '<i class="fas fa-user-check fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Attendance Not Uploaded!"></i>';
                $pictureIcon = '<i class="fas fa-image fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Pictures Not Uploaded!"></i>';
                $reportIcon = '<i class="fas fa-file-alt fa-lg" style="color: gray; margin-left: 10px; margin-right: 10px;" title="Report Not Uploaded!"</i>';
        
                $movs_checkedValue = $activity->movs_name ? json_decode($activity->movs_name) : [];
                if (in_array("Attendance", $movs_checkedValue)) {
                    $attendanceIcon = '<i class="fas fa-user-check fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"></i>';
                }
                if (in_array("Pictures", $movs_checkedValue)) {
                    $pictureIcon = '<i class="fas fa-image fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"></i>';
                }
                if (in_array("Report", $movs_checkedValue)) {
                    $reportIcon = '<i class="fas fa-file-alt fa-lg" style="color: green; margin-left: 10px; margin-right: 10px;"</i>';
                }
                $combinedIcons = $attendanceIcon .' '. $pictureIcon .' '. $reportIcon;
        
                $output .= '<tr>
                    <td><a href="' . route('view-cbpl-activity', ['id' => $activity->id]) . '" target="_self" class="activity-link">
                    <i class="fas fa-hand-point-right fa-lg" style="margin-right: 5px;"></i>&nbsp;' . $activity->title . '
                        </a></td>
                    <td data-sort="' . \Carbon\Carbon::parse($activity->date)->format('Y-m-d') . '">' . \Carbon\Carbon::parse($activity->date)->format('d-m-Y') . '</td>
                    <td>' . $activity->district->district. '</td>
                    <td>' . $activity->camp->title. '</td>
                    <td>' . $activity->username->name . '</td>
                    <td style="width: 100px;">' . $combinedIcons . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No records present in the database for this district!</h1>';
        }
    }
    // Get table Data By District Dropdown Beneficiries Count
    public function getByDistrictBeneficiaryCbpl($district_id)
    {
        // for Male Host
        $countHostMale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '1')
        ->where('nationality', 'LIKE', 'P%')->where('code','LIKE','CBPL%')
        ->count();
        // for Female Host
        $countHostFemale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '2')
        ->where('nationality', 'LIKE', 'P%')->where('code','LIKE','CBPL%')
        ->count();
        // for Male Refugees
        $countRefugeesMale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '1')
        ->where('nationality', 'LIKE', 'A%')->where('code','LIKE','CBPL%')
        ->count();
        // for Female Refugees
        $countRefugeesFemale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '2')
        ->where('nationality', 'LIKE', 'A%')->where('code','LIKE','CBPL%')
        ->count();
        // Total Host
        $totalHost = $countHostMale + $countHostFemale;
        // Total Refugess
        $totalRefugees = $countRefugeesMale + $countRefugeesFemale;
        $countMale = $countHostMale + $countRefugeesMale;
        $countFemale = $countHostFemale + $countRefugeesFemale;
        $total= $countMale + $countFemale;
        $countActivities = Activities::where('district_id', $district_id)->where('title','LIKE','CBPL%')->count();
        return response()->json([
        'countMale' => $countMale,
        'countFemale' => $countFemale,
        'total' => $total,
        'countActivities' => $countActivities,
        'countHostMale' => $countHostMale,
        'countHostFemale' => $countHostFemale,
        'countRefugeesMale' => $countRefugeesMale,
        'countRefugeesFemale' => $countRefugeesFemale,
        'totalHost' => $totalHost,
        'totalRefugees' => $totalRefugees,
        ]);
    }
    // END CBP Storing
    // clicked on the activity to View the participants 
    public function viewCbplActivity($id)
    {
        $awarenessSessions = DB::table('participant_l_p_s')
                        ->join('genders', 'genders.id', '=', 'participant_l_p_s.gender_id')
                        ->join('camps', 'camps.id', '=', 'participant_l_p_s.camp')
                        ->join('districts', 'districts.id', '=', 'participant_l_p_s.district_id')
                        ->select(
                            'participant_l_p_s.name',
                            'participant_l_p_s.father',
                            'genders.gender',
                            DB::raw("CASE WHEN participant_l_p_s.identity_code = 'undocument' THEN 'N/A' ELSE participant_l_p_s.document_no END AS document_no"),
                            'participant_l_p_s.contact',
                            'districts.district',
                            'camps.title as camp', // Select the camp title column as 'CAMP'
                            'participant_l_p_s.session_date',
                            'participant_l_p_s.identity_code',
                        )
                        ->where('participant_l_p_s.activities_id', $id) 
                        ->get();

        $data = Activities::find($id);
        $title = strtoupper($data->title);
        $genders = DB::table('genders')->get();
        $districts = DB::table('districts')->get();
        $participants = ParticipantLPS::where('activities_id', $id)->get();
        $countMale = $participants->where('gender_id', 1)
                    ->where('activities_id', $id) 
                    ->count();
        $countFemale= $participants->where('gender_id', 2) 
                    ->where('activities_id', $id)
                    ->count();   
        $total = $countMale +$countFemale;
        $countHostMale= ParticipantLPS::where('gender_id', 1)
                            ->where('activities_id', $id)
                            ->where('nationality', 'LIKE', 'P%')
                            ->count();
        $countHostFemale = ParticipantLPS::where('gender_id', 2)
                            ->where('activities_id', $id)
                            ->where('nationality', 'LIKE', 'P%')
                            ->count();
        $countRefMale = ParticipantLPS::where('gender_id', 1)
                            ->where('activities_id', $id)
                            ->where('nationality', 'LIKE', 'A%')
                            ->count();
        $countRefFemale = ParticipantLPS::where('gender_id', 2)
                            ->where('activities_id', $id)
                            ->where('nationality', 'LIKE', 'A%')
                            ->count();
        return view('employee.cbpl.cbpl-table', [
        'awarenessSessions' => $awarenessSessions,
        'genders' => $genders,
        'districts' => $districts,
        "title"=>$title ,
        "id"=>$id,
        "countMale"=>$countMale,
        "countFemale"=>$countFemale,
        "total"=>$total,
        "countHostMale"=>$countHostMale,
        "countHostFemale"=>$countHostFemale,
        "countRefMale"=>$countRefMale,
        "countRefFemale"=>$countRefFemale,
        ]);
       
    }
    // Add CBPL Participants
    public function storing(Request $request)
    {
        $user_id = Auth::id();
        $activities_id = $request->input('id');
        $activity = DB::table('activities')
            ->where('activities.id', $activities_id)
            ->first(); // Using first() assuming you expect only one activity

        if ($activity) {
            $campId = $activity->camp_id;
            $district_id = $activity->district_id;
            $dateActivity = $activity->date;
            // Now you have $campId containing the camp_id value from the activity
        }
        // Define custom error messages for size rule
        $customMessages = [
            'identity.size' => 'Must be: XXXXX-XXXXXXX-X.'
        ];
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'identity' => ['required'],
        ], $customMessages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->all() // Send all validation errors
            ]);
        }

        try{
            $codeContact = $request->input('countrycode') .' '. $request->input('contact');
            $cbpl =[
                'name'=>$request->name,
                'father'=>$request->father,
                'gender_id'=>$request->gender,
                'document_no'=>$request->identity,
                'contact'=>$codeContact,
                'district_id'=>$district_id,
                'camp'=>$campId,
                'session_date'=>$dateActivity,
                'user_id'=>$user_id,
                'activities_id'=>$activities_id,
                'nationality'=>$request->input('nationality'),
                'identity_code'=>$request->input('identity_code'),
                'code'=>'CBPL'
            ];
            ParticipantLPS::create($cbpl);
            return response()->json(['success' => true, 'message' => 'Data added successfully']);
        }
        catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add data. An unexpected error occurred.'
            ]);
        }
        
    }
    // Excel Export CBPL Data
    public function exportExcel()
    {
        $currentDateTime = Carbon::now()->format('Ymd_His');
        $fileName = 'CommunityBased-ParaLegal_' . $currentDateTime . '.xlsx';
        return Excel::download(new ParticipantLPSExport('CBPL'), $fileName);
    }
}
