<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activities;
use App\Models\ParticipantLPS;
use Illuminate\Support\Facades\Auth;
use App\Exports\ParticipantLPSExport;
use Illuminate\Support\Facades\Validator;
use DB;
use Excel;
use Carbon\Carbon;
class ParticipantLPSController extends Controller
{
    public function viewAwarenessActivity($id)
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
     // Count male and female hosts separately
        $countHostMale = ParticipantLPS::where('nationality', 'LIKE', 'P%')
        ->where('gender_id', '1')
        ->where('activities_id', $id)
        ->count();
        $countHostFemale = ParticipantLPS::where('nationality', 'LIKE', 'P%')
        ->where('gender_id', '2')
        ->where('activities_id', $id)
        ->count();

        // Count male and female refugees separately
        $countRefugeesMale = ParticipantLPS::where('nationality', 'LIKE', 'A%')
        ->where('gender_id', '1')
        ->where('activities_id', $id)
        ->count();
        $countRefugeesFemale = ParticipantLPS::where('nationality', 'LIKE', 'A%')
        ->where('gender_id', '2')
        ->where('activities_id', $id)
        ->count();

        // Calculate the total counts for hosts and refugees
        $totalHosts = $countHostMale + $countHostFemale;
        $totalRefugees = $countRefugeesMale + $countRefugeesFemale;
        return view('employee.lpsactivity.awareness-table', [
        'awarenessSessions' => $awarenessSessions,
        'genders' => $genders,
        'districts' => $districts,
        "title"=>$title ,
        "id"=>$id,
        "countHostMale"=>$countHostMale,
        "countHostFemale"=>$countHostFemale,
        "countRefugeesMale"=>$countRefugeesMale,
        "countRefugeesFemale"=>$countRefugeesFemale,
        "totalHosts"=>$totalHosts,
        "totalRefugees"=>$totalRefugees,

        ]);
       
    }
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
            $las =[
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
                'identity_code'=>$request->input('identity_code')
            ];
            ParticipantLPS::create($las);
            return response()->json(['success' => true, 'message' => 'Data added successfully']);
        }
        catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add data. An unexpected error occurred.'
            ]);
        }
        
    }
    // get all fetchAllLAS ajax request Table Data
    public function fetchAllLAS()
    {
        $particpantsLas = ParticipantLPS::all();
        
        $output = '';
        if($particpantsLas->count()>0){
            $output .= '<table class="table nowrap table-striped table-sm align-middle table-bordered" id="dataTableExample">
            <thead style="background-color: #f59014; color: white;">
              <tr>
                <th style="color: white;">Name</th>
                <th style="color: white;">Father</th>
                <th style="color: white;">Gender</th>
                <th style="color: white;">Document</th>
                <th style="color: white;">District</th>
                <th style="color: white;">District</th>
                <th style="color: white;">Contact</th>
                <th style="color: white;">Camp</th>
                <th style="color: white;">Session</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($particpantsLas as $las) {
				$output .= '<tr>
                <td>' . $las->name .'</td>
                <td>' . $las->father.'</td>
                <td>' . $las->gender->gender . '</td>
                <td>' . $las->document_no . '</td>
                <td>' . $las->contact . '</td>
                <td>' . $las->district->district . '</td>
                <td>' . $las->camp . '</td>
                <td data-sort="' . \Carbon\Carbon::parse($las->session_date)->format('Y-m-d') . '">
            ' . \Carbon\Carbon::parse($las->session_date)->format('d-m-Y') . '
                </td>
                </tr>';
            }
            $output .= '</tbody></table>';
			echo $output;
        } else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }
    }
    public function getDistrictGenderCounts($district_id)
    {
        // for Male Host
        $countHostMale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '1')
        ->where('nationality', 'LIKE', 'P%')
        ->count();
        // for Female Host
        $countHostFemale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '2')
        ->where('nationality', 'LIKE', 'P%')
        ->count();
        // for Male Refugees
        $countRefugeesMale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '1')
        ->where('nationality', 'LIKE', 'A%')
        ->count();
        // for Female Refugees
        $countRefugeesFemale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '2')
        ->where('nationality', 'LIKE', 'A%')
        ->count();
        // Total Host
        $totalHost = $countHostMale + $countHostFemale;
        // Total Refugess
        $totalRefugees = $countRefugeesMale + $countRefugeesFemale;

        $countMale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '1') 
        ->count();
        
        $countFemale = ParticipantLPS::where('district_id', $district_id)
        ->where('gender_id', '2') 
        ->count();
        $total= $countMale + $countFemale;
        $countActivities = Activities::where('district_id', $district_id)->count();
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
    public function exportExcel()
    {
        $currentDateTime = Carbon::now()->format('Ymd_His'); // Format: YearMonthDay_HourMinuteSecond
        $fileName = 'awareness-session_' . $currentDateTime . '.xlsx';
        // return Excel::download(new ParticipantLPSExport, 'awareness-session.xlsx');
        return Excel::download(new ParticipantLPSExport('LPS'), $fileName);
    }
}
