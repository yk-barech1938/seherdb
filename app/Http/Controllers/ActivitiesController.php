<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activities;
use App\Models\Camp;
use App\Models\Designation;
use App\Models\Proj_Participants;
use App\Models\ActivityParticipant;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User; 
use Illuminate\Support\Facades\Redirect;
use App\Models\Images;
use PDF;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; 

class ActivitiesController extends Controller
{
    public function fetchCamps(Request $request)
    {
        $camps = Camp::where('district_id', $request->district_id)->get();
        return response()->json($camps);
    }
    public function showForm()
    {
        // You can customize this view to include the form for creating activities
        return view('employee.activities.create');
    }

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

            // $otherParticipantNames = $request->input('other_participant_name');
            // $otherParticipantDesignations = $request->input('other_participant_designation'); 
            $id = Auth::id();
            $user = DB::table('users')->find($id);
            // $dist_id = $user->district_id;
            $camp = $request->input('camp');
            // $districtInput = $request->input('district');
            if ($camp == 'other') {
                $otherCamp = $request->input('otherCamp');
                $newCamp = new Camp();
                $newCamp->title = $otherCamp;
                $newCamp->district_id = $request->input('district'); // Assign district_id here
                $newCamp->save();
                $newCampId = $newCamp->id;
                // Create a new activity for Other camp
                $activity = Activities::create([
                        'title' =>"LPS-Awareness Session",
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
                        'title' =>"LPS-Awareness Session",
                        'district_id' => $request->input('district'),
                        'user_id' => $id,
                        'movs_name' => json_encode($request->movsCheckBox), // Store as JSON
                        'date' => $request->input('date'),
                        'camp_id' => $request->input('camp'), // Assuming 'camp' is the name of the select field
                        'teammembers'=>$participantsString

                    ]);
            }
            // not used just for tracking record
            ActivityParticipant::create([
                'participants_name' => $participantsString,
                'designation_name' => 'LegalAwarenessSession',
                'activity_id'=>$activity->id,
            ]);
            // $tags = json_encode($request->tags);
            // Log::info('Tags Data:', ['tags' => $tags]);
            // dd($tags);
            // print_r($tags);
            // foreach ($tags as $tag) {
            //     ActivityParticipant::create([
            //         'participants_name' => $tag,
            //         'activity_id' => $activity->id
            //     ]);
            // }

            // if (!is_null($tags)) {
            //     foreach ($tags as $tag) {
            //         // Create ActivityParticipant record


            //         // Check if the participant name exists in proj_participants
            //         $existingParticipant = Proj_Participants::where('participant_name', $tag)->first();

            //         if (!$existingParticipant) {
            //             Proj_Participants::create([
            //                 'participant_name' => $tag,
            //                 'project_id' => 1,
            //                 'designation_id' => 0
            //             ]);
            //         }
            //     }
            // }
            // Saving into Activitiies of participants in case of Other Participants If required
            // $teammembers = $request->input('teammembers');
            // if ($teammembers == 'other') {
            //     $request->validate([
            //         'other_participant_name.*' => 'required|string|max:255',
            //         'other_participant_designation.*' => 'required|string|max:255',
            //     ]);
            //     $otherParticipantNames = $request->input('other_participant_name');
            //     $otherParticipantDesignations = $request->input('other_participant_designation');
    
            //     foreach ($otherParticipantNames as $key => $name) {
            //         // Create Designation record if not exists, and get its id
            //         $designation = Designation::firstOrCreate(['name' => $otherParticipantDesignations[$key]]);
            //         $desig_id = $designation->id;
    
            //         // Create Proj_Participants record for each "Other" participant
            //         $projParticipant = Proj_Participants::create([
            //             'participant_name' => $name,
            //             'designation_id' => $desig_id,
            //             'project_id' => 1, // Assuming project_id is always 1
            //         ]);
    
            //         // Now create ActivityParticipant record with projParticipant's id
            //         ActivityParticipant::create([
            //             'participants_name' => $projParticipant->id, // Use projParticipant id
            //             'designation_name' => $desig_id,
            //             'activity_id' => $activity->id, 
            //             'data_field' => 'other',
            //         ]);
            //     }
            // }
            // else{
            // }
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
                return response()->json(['success' => true, 'message' => 'CBPL Data added successfully']);

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
    // Generate PDF view file for AwarenessSession
    public function generatePDF($id)
    {
        $images = Images::where('activities_id', $id)->get();
        $pdfFileName = 'images_' . uniqid() . '.pdf';
        $pdf = PDF::loadView('pdf.images', ['images' => $images]);
        return $pdf->stream($pdfFileName);
    }
    // get all Awareness Session Activites ajax request Table Data
    public function fetchAllAwarenessSession()
    {
        $userId = Auth::id();
        $userRoleId = Auth::user()->role_id;
        if ($userRoleId == 2) {
            $activities = Activities::where('title', 'like', 'LPS%')->select('id','title', 'district_id', 'user_id', 'date', 'movs_name', 'camp_id','teammembers')->get();
        } else {
            // Retrieve activities based on the authenticated user's ID
            // $activities = Activities::where('user_id', $userId)->get();
            $activities = Activities::where('user_id', $userId)->where('title', 'like', 'LPS%')->select('id','title', 'district_id', 'user_id', 'date', 'movs_name', 'camp_id','teammembers')->get();
        }
        // $activities = Activities::all();

        $output = '';
        if($activities->count()>0){
            $output .= ' <table id="dataTableExample" class="table table-striped table-bordered" style="width:100%; font-size: small;">
            <thead style="background-color: #6571ff;">
              <tr>
                <th style="color: #f8f8ff;">Name</th>
                <th style="color: #f8f8ff;">Session Date</th>
                <th style="color: #f8f8ff;">District</th>
                <th style="color: #f8f8ff;">Camp</th>
                <th style="color: #f8f8ff; width: 100px;">Team Members</th>
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
             
            
				$output .= '<tr >
                <td style="font-size: 12px; color: #444444;"><a href="' . route('view-awareness-activity', ['id' => $activity->id]) . '" target="_self" class="activity-link">
                <i class="fas fa-hand-point-right fa-lg" style="margin-right: 5px;"></i>&nbsp;' . $activity->title . '
                    </a></td>
  
                <td style="font-size: 12px; color: #444444;" data-sort="' . \Carbon\Carbon::parse($activity->date)->format('Y-m-d') . '">
                ' . \Carbon\Carbon::parse($activity->date)->format('d-m-Y') . '
                    </td>
                <td style="font-size: 12px; color: #444444;" >' . $activity->district->district. '</td>
                <td style="font-size: 12px; color: #444444;">' . $activity->camp->title. '</td>

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
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }

    // get Awareness Session Activities ajax request Table Data based on district
    public function fetchAwarenessSessionByDistrict($districtId)
    {
        $activities = Activities::where('district_id', $districtId)
        ->where('title', 'like', 'LPS%')
        ->select('id', 'title', 'district_id', 'user_id', 'date', 'movs_name', 'camp_id','teammembers')
        ->get();
        $output = '';
        if ($activities->count() > 0) {
            $output .= '<table id="dataTableExample" class="table table-striped table-bordered" style="width:100%; font-size: small;">
                <thead style="background-color: #6571ff;">
                    <tr>
                        <th style="color: #f8f8ff;">Name</th>
                        <th style="color: #f8f8ff;">Session Date</th>
                        <th style="color: #f8f8ff;">District</th>
                        <th style="color: #f8f8ff;">Camp</th>
                        <th style="color: #f8f8ff; width: 100px;">Team Members</th>
                        <th style="color: #f8f8ff;">Check</th>
                        <th style="color: #f8f8ff;">Movs</th>
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
                    <td><a href="' . route('view-awareness-activity', ['id' => $activity->id]) . '" target="_self" class="activity-link">
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
                    <td style="width: 50px; text-align: center;">
                        <a href="' . route('generate-pdf', ['id' => $activity->id]) . '" target="_blank">
                            <i class="fas fa-eye fa-lg" style="color: #F5761A;"></i>
                        </a>
                    </td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No records present in the database for this district!</h1>';
        }
    }
    public function searchAwarenessActivities(Request $request) 
    {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        // getting the role_id then will shows the data according to that.
        $id = Auth::user()->id;
        $roleId = Auth::user()->role_id;
        if ($roleId == 1) 
        {
            // incase of 1 get the data according to the current user only 
            $activities = DB::table('activities')
            ->join('districts', 'districts.id', '=', 'activities.district_id')
            ->join('camps', 'camps.id', '=', 'activities.camp_id')
            ->join('users', 'users.id', '=', 'activities.user_id')
            ->select('activities.*', 'districts.district','camps.title as camp','users.name')
            ->where('activities.date', '>=', $fromDate)
            ->where('activities.date', '<=', $toDate)
            ->where('activities.title', 'like', 'LPS%')
            ->where('activities.user_id', $id)
            ->get();
        } 
        elseif ($roleId == 2) 
        {
            // for agent based to deal with the data getting all the awareness session
            $activities = DB::table('activities')
            ->join('districts', 'districts.id', '=', 'activities.district_id')
            ->join('camps', 'camps.id', '=', 'activities.camp_id')
            ->join('users', 'users.id', '=', 'activities.user_id')
            ->select('activities.*', 'districts.district','camps.title as camp','users.name')
            ->where('activities.date', '>=', $fromDate)
            ->where('activities.date', '<=', $toDate)
            ->where('activities.title', 'like', 'LPS%')
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
                        <th style="color: #f8f8ff;">Session Date</th>
                        <th style="color: #f8f8ff;">District</th>
                        <th style="color: #f8f8ff;">Camp</th>
                        <th style="color: #f8f8ff; width: 100px;">Team Members</th>
                        <th style="color: #f8f8ff;">Check</th>
                        <th style="color: #f8f8ff;">Movs</th>
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
                    <td><a href="' . route('view-awareness-activity', ['id' => $activity->id]) . '" target="_self" class="activity-link">
                    <i class="fas fa-hand-point-right fa-lg" style="margin-right: 5px;"></i>&nbsp;' . $activity->title . '
                        </a></td>
                    <td data-sort="' . \Carbon\Carbon::parse($activity->date)->format('Y-m-d') . '">' . \Carbon\Carbon::parse($activity->date)->format('d-m-Y') . '</td>
                    <td>' . $activity->district. '</td>
                    <td>' . $activity->camp. '</td>
                    <td style="text-align: center; margin:1px; padding: 0 5px;"> 
                        <span style="font-size: 12px; display: block;"">' 
                            . $activity->name. 
                        '</span>'.
                        '<span style="font-size: 12px; color: #888888; font-weight: bold; display: block;">'
                            . $activity->teammembers.'
                        </span>
                    </td>
                    <td style="width: 100px;">' . $combinedIcons . '</td>
                    <td style="width: 50px; text-align: center;">
                        <a href="' . route('generate-pdf', ['id' => $activity->id]) . '" target="_blank">
                            <i class="fas fa-eye fa-lg" style="color: #F5761A;"></i>
                        </a>
                    </td>
                </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">No records present in the database for this district!</h1>';
        }
    }
    public function getTeamMembers(Request $request)
    {
        $tags = [];

        if ($request->has('all')) {
            $tags = Proj_Participants::all();
        } else {
            if ($search = $request->name) {
                $tags = Proj_Participants::where('participant_name', 'LIKE', '%'.$search . '%')->get();
            }
        }
        return response()->json($tags);
    }
}
