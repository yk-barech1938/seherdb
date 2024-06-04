<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\AwarenessSession;
use App\Models\ParticipantLPS;
use App\Models\Activities;
use App\Models\Proj_Participants;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AwarenessSessionController extends Controller
{
    // Employee Awareness Activity View
    public function AwarenessSession()
    {

        if (Auth::check()) {
             $user = Auth::user(); 
             $districtId = $user->district_id; 
             $camps = DB::table('camps')->get();
            }
        $activities = Activities::where('title', 'LIKE', 'LP%')->get();
    //     $activities = Activities::leftJoin('activity_participants', function($join) {
    //     $join->on('activities.id', '=', 'activity_participants.activity_id');
    // })
    // ->where('activities.title', 'LIKE', 'LP%')
    // ->select('activities.*', 'activity_participants.participants_name')
    // ->get();


        $countMale = ParticipantLPS::where('gender_id', '1')->count();
        $countFemale = ParticipantLPS::where('gender_id', '2')->count();
        $total = $countMale + $countFemale;
         // Count records where nationality starts with "P"
         $countHostMale = ParticipantLPS::where('nationality', 'LIKE', 'P%')->where('gender_id', '1') 
         ->count();
         $countHostFemale = ParticipantLPS::where('nationality', 'LIKE', 'P%')->where('gender_id', '2') 
         ->count();
         // Count records where nationality starts with "A"
         $countRefugeesMale = ParticipantLPS::where('nationality', 'LIKE', 'A%')->where('gender_id', '1') 
         ->count();
          // Count records where nationality starts with "A"
          $countRefugeesFemale = ParticipantLPS::where('nationality', 'LIKE', 'A%')->where('gender_id', '2') 
          ->count();
        $totalHost = $countHostMale + $countHostFemale;
        $totalRefugees = $countRefugeesMale + $countRefugeesFemale;
        $districts = DB::table('districts')->get();
        $users = DB::table('users')->get();
        $ds = Proj_Participants::where('project_id',1)->get();
        $project_participants = DB::table('proj_participants')->where('project_id',1)->get();

        return view('employee.lpsactivity.awareness-activity', [
            'activities' => $activities,
            'districts' => $districts,
            'users' => $users,
            'countMale' => $countMale,
            'countFemale' => $countFemale,
            'countHostMale' => $countHostMale,
            'countHostFemale' => $countHostFemale,
            'countRefugeesMale' => $countRefugeesMale,
            'countRefugeesFemale' => $countRefugeesFemale,
            'total' => $total,
            'totalHost' => $totalHost,
            'totalRefugees' => $totalRefugees,
            'camps' => $camps,
            'project_participants' => $project_participants,
            'ds'=>$ds
        ]);
    }
    // this is no ise 
    public function indexAdmin()
    {
       // Count males
        $countMale = AwarenessSession::where('gender_id', '1')->count();

        // Count females
        $countFemale = AwarenessSession::where('gender_id', '2')->count();
        $total = $countMale + $countFemale;

        $genders = DB::table('genders')->get();
        $districts = DB::table('districts')->get();

        return view('admin.legalprotection.awarenesscrud', [
            'genders' => $genders,
            'districts' => $districts,
            'countMale'=>$countMale,
            'countFemale'=>$countFemale,
            'total'=>$total
        ]);

    }
    public function fetchAll()
    {
        $awarenessSessions = AwarenessSession::all();
        
        $output = '';
        if($awarenessSessions->count()>0){
            $output .= '<table class="table nowrap table-striped table-sm align-middle table-bordered" id="dataTableExample">
            <thead style="background-color: #f59014; color: white;">
              <tr>
                <th style="color: white;">Name</th>
                <th style="color: white;">Father</th>
                <th style="color: white;">Gender</th>
                <th style="color: white;">Document</th>
                <th style="color: white;">Contact</th>
                <th style="color: white;">District</th>
                <th style="color: white;">Camp</th>
                <th style="color: white;">Session</th>
                <th style="color: white;">Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($awarenessSessions as $awarenessSession) {
				$output .= '<tr>
                <td>' . $awarenessSession->name .'</td>
                <td>' . $awarenessSession->father.'</td>
                <td>' . $awarenessSession->gender->gender . '</td>
                <td>' . $awarenessSession->document_no . '</td>
                <td>' . $awarenessSession->contact . '</td>
                <td>' . $awarenessSession->district->district . '</td>
                <td>' . $awarenessSession->camp . '</td>
                <td data-sort="' . \Carbon\Carbon::parse($awarenessSession->session_date)->format('Y-m-d') . '">
            ' . \Carbon\Carbon::parse($awarenessSession->session_date)->format('d-m-Y') . '
                </td>
                 <td style="text-align: center;">
                 <a href="#" id="' . $awarenessSession->id . '" class="text-success mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="fa fa-edit h4"></i></a> | 
                 <a href="#" id="' . $awarenessSession->id . '" class="text-danger mx-1 deleteIcon"><i class="fa fa-trash h4"></i></a>
             </td>
                </tr>';
            }
            $output .= '</tbody></table>';
			echo $output;
        } else {
			echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
        }

    }

    public function awarenessEdit(Request $request)
    {
        $id = $request->id;
        $awarenessSession = AwarenessSession::find($id);
        return response()->json($awarenessSession);

    }
    // Update Ajax Modal Request
    public function awarenessUpdate(Request $request)
    {
        $awarenessSession = AwarenessSession::find($request->id);
         // Check if the record exists
     if ($awarenessSession) {
        // Update the record with the provided data
        $awarenessSession->update([
            'name' => $request->name,
            'father' => $request->father,
            'gender_id' => $request->gender,
            'document_no' => $request->document_no,
            'contact' => $request->contact,
            'district_id' => $request->district,
            'camp' => $request->camp,
            'session_date' => $request->session_date,
        ]);

        return response()->json([
            'status' => 200
        ]);
     } else {
        // Return an error response if the record is not found
        return response()->json([
            'status' => 404,
            'message' => 'Record not found',
        ], 404);
     }
    }
}
