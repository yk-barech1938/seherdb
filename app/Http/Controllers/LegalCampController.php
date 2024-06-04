<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator; 
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityParticipant;
use App\Models\Proj_Participants;
use App\Models\ParticipantLPS;
use Illuminate\Http\Request;
use App\Models\Activities;
use App\Models\District;
use App\Models\Camp;
use Carbon\Carbon;
use DB;

class LegalCampController extends Controller
{
    public function index()
    {

        if (Auth::check()) {
            $user = Auth::user(); 
            $districtId = $user->district_id; 
            $camps = DB::table('camps')->get();
        }
        // $countMale = ParticipantLPS::where('gender_id', '1')->where('code', 'LCamp')->count();
        // $countFemale = ParticipantLPS::where('gender_id', '2')->where('code', 'LCamp')->count();
        // $total = $countMale + $countFemale;
        //  // Count records where nationality starts with "P"
        //  $countHostMale = ParticipantLPS::where('nationality', 'LIKE', 'P%')->where('gender_id', '1')->where('code', 'LCamp')
        //  ->count();
        //  $countHostFemale = ParticipantLPS::where('nationality', 'LIKE', 'P%')->where('gender_id', '2')->where('code', 'LCamp') 
        //  ->count();
        //  // Count records where nationality starts with "A"
        //  $countRefugeesMale = ParticipantLPS::where('nationality', 'LIKE', 'A%')->where('gender_id', '1')->where('code', 'LCamp') 
        //  ->count();
        //   // Count records where nationality starts with "A"
        //   $countRefugeesFemale = ParticipantLPS::where('nationality', 'LIKE', 'A%')->where('gender_id', '2')->where('code', 'LCamp') 
        //   ->count();
        // $totalHost = $countHostMale + $countHostFemale;
        // $totalRefugees = $countRefugeesMale + $countRefugeesFemale;
        $countActivity = Activities::where('title', 'like', 'Camp%')->count();
        $districts = District::all();
        $ds = Proj_Participants::where('project_id',1)->get();
        return view('employee.legalcamp.legalcamp-activity',compact(
            'countActivity', 
            'camps',
            'districts',
            'ds',
        ));
    }
        // get all Legal Camp Activites ajax request Table Data
    public function fetchAllLegalCamp()
    {
        $userId = Auth::id();
        $userRoleId = Auth::user()->role_id;
        if ($userRoleId == 2) {
            $activities = Activities::where('title', 'like', 'Camp%')
            ->select('id','title', 'district_id', 'user_id', 'date', 'movs_name', 'camp_id','teammembers')
            ->get();
            
        } else {
            // Retrieve activities based on the authenticated user's ID
            $activities = Activities::where('user_id', $userId)->where('title', 'like', 'Camp%')->select('id','title', 'district_id', 'user_id', 'date', 'movs_name', 'camp_id','teammembers')->get();
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
                <th style="color: #f8f8ff; width: 100px;">Conducted</th>
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
                <td><a href="' . route('view-camp-beneficiary', ['id' => $activity->id]) . '" target="_self" class="activity-link">
                <i class="fas fa-hand-point-right fa-lg" style="margin-right: 5px;"></i>&nbsp;' . $activity->title . '
                    </a></td>
  
                <td data-sort="' . \Carbon\Carbon::parse($activity->date)->format('Y-m-d') . '">
                ' . \Carbon\Carbon::parse($activity->date)->format('d-m-Y') . '
                    </td>
                <td>' . $activity->district->district. '</td>
                <td>' . $activity->camp->title. '</td>
                <td style="text-align: center; margin:1px; padding: 0 5px;"> 
                    <span style="font-size: 12px; display: block;"">' 
                        . $activity->username->name. 
                    '</span>'.
                    '<span style="font-size: 12px; color: #888888; font-weight: bold; display: block;">'
                        . $activity->teammembers.'
                    </span>
                </td>
                <td style="width: 100px;">' . $combinedIconss . '</td>
                </tr>';
                $combinedIconss="";
            }
            $output .= '</tbody></table>';
			echo $output;
        } else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the Legal Camp!</h1>';
        }
    }
    // Store Legal Camp Activities 
    // store Legal Camp Activity:  Copied from Awareness Session
    public function storeActivity(Request $request)
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
                'title.*' => 'string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $participantNames = $request->input('title', []);
            $cleanedParticipantNames = array_map(function ($name) {
                return rtrim($name, '*');
            }, $participantNames);
            $participantsString = implode(' | ', $cleanedParticipantNames);

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
                        'title' =>"Camp",
                        'district_id' => $request->input('district'),
                        'user_id' => $id,
                        'movs_name' => json_encode($request->movsCheckBox), // Store as JSON
                        'date' => $request->input('date'),
                        'camp_id' => $newCampId, // Assuming 'camp' is the name of the select field
                        'teammembers'=>$participantsString

                ]);
            }
            else{
                    // Create a new activity
                    $activity = Activities::create([
                        'title' =>"Camp",
                        'district_id' => $request->input('district'),
                        'user_id' => $id,
                        'movs_name' => json_encode($request->movsCheckBox), // Store as JSON
                        'date' => $request->input('date'),
                        'camp_id' => $request->input('camp'), // Assuming 'camp' is the name of the select field
                        'teammembers'=>$participantsString

                    ]);
            }
            ActivityParticipant::create([
                'participants_name' => $participantsString,
                'designation_name' => 'LegalCamp',
                'activity_id'=>$activity->id,
            ]);
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

    // Get search by Date Range Filter CBPL Activities
    public function searchLegalCampActivities(Request $request) 
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        // getting the role_id then will shows the data according to that.
        $id = Auth::user()->id;
        $roleId = Auth::user()->role_id;
        if ($roleId == 1) 
        {
            $activities = Activities::whereDate('date', '>=', $fromDate)
                        ->whereDate('date', '<=', $toDate)
                        ->where('user_id', $id)->where('title', 'Camp')
                        ->get();
        } 
        elseif ($roleId == 2) 
        {
            $activities = Activities::whereDate('date', '>=', $fromDate)
                        ->whereDate('date', '<=', $toDate)->where('title', 'Camp')
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
                        <th style="color: #f8f8ff; width: 100px;">Conducted</th>
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
                    <td><a href="' . route('view-camp-beneficiary', ['id' => $activity->id]) . '" target="_self" class="activity-link">
                    <i class="fas fa-hand-point-right fa-lg" style="margin-right: 5px;"></i>&nbsp;' . $activity->title . '
                        </a></td>
                    <td data-sort="' . \Carbon\Carbon::parse($activity->date)->format('Y-m-d') . '">' . \Carbon\Carbon::parse($activity->date)->format('d-m-Y') . '</td>
                    <td>' . $activity->district->district. '</td>
                    <td>' . $activity->camp->title. '</td>
                    <td style="text-align: center; margin:1px; padding: 0 5px;"> 
                        <span style="font-size: 12px; display: block;"">' 
                            . $activity->username->name. 
                        '</span>'.
                        '<span style="font-size: 12px; color: #888888; font-weight: bold; display: block;">'
                            . $activity->teammembers.'
                        </span>
                    </td>
                    <td style="width: 100px;">' . $combinedIcons . '</td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No records present in the database for this Date!</h1>';
        }
    }
    // clicked on the activity to View the participants 
    public function viewLegalCampBeneficiary($id)
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
                            'camps.title as camp',
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
        return view('employee.legalcamp.legalcamp-table', [
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

    // Add Legal Camp Participants
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
            $legalCampPostData =[
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
                'code'=>'Camp'
            ];
            ParticipantLPS::create($legalCampPostData);
            return response()->json(['success' => true, 'message' => 'Legal Camp Beneficiary added successfully']);
        }
        catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add Legal Camp. An unexpected error occurred.'
            ]);
        }
        
    }
}
