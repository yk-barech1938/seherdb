<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HelplineActivity;
use App\Models\User;
use App\Models\HelplineCall;
use App\Models\PresentAddress;
use Illuminate\Support\Facades\Validator; 
use Carbon\Carbon;
use DB;

class HelplineCallsController extends Controller
{
    public function index()
    {

        $users = User::where('role_id', 11)->get();
        $activities_helpline= HelplineActivity::get();
        $totalActivities = $activities_helpline->count();
        $maleCount = HelplineCall::where('gender', 0)->count();
        $femaleCount = HelplineCall::where('gender', 1)->count();
        $totalCount = $maleCount + $femaleCount;
        $malePorCount = HelplineCall::where('gender', 0)
        ->where('card_holder', 0)
        ->count();
        $maleNonPorCount = $maleCount-$malePorCount;
        $femalePorCount = HelplineCall::where('gender', 1)
        ->where('card_holder', 0)
        ->count();
        $femaleNonPorCount = $femaleCount - $femalePorCount;
        $totalPor =  $malePorCount + $femalePorCount;
        $totalNonPor = $totalCount - $totalPor;
        return view('employee.helpline.helplinecalls-activity',[
            'users'=>$users,'activities_helpline'=>$activities_helpline,
            'maleCount'=>$maleCount,'femaleCount'=>$femaleCount,'totalCount'=>$totalCount,
            'totalActivities'=>$totalActivities,'malePorCount'=>$malePorCount,'maleNonPorCount'=>$maleNonPorCount,
            'femalePorCount'=>$femalePorCount,
            'femaleNonPorCount'=>$femaleNonPorCount,
            'totalPor'=>$totalPor,
            'totalNonPor'=>$totalNonPor,
        ]);
    }
    // Helpline Call's Day Store
    public function storing(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => 'required|date',

            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $id = Auth::id();
            $helplinecalls = HelplineActivity::create([
                'title' =>"Helpline's Calls",
                'user_id' => $id,
                'date' => $request->input('date'),
                'data_user'=>$request->input('data_user'),
                'description'=>$request->description
            ]);

            return response()->json(['success' => true, 'message' => 'Helpline Activitiy created successfully!']);
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
    // check if the current date activity exists
    public function checkActivityExists()
    {
        $userId = Auth::id(); 
        $currentDate = Carbon::now()->toDateString();
        $activityExists = HelplineActivity::where('user_id', $userId)
        ->where('date', $currentDate) 
        ->exists();
        
        return response()->json(['activityExists' => $activityExists]);
    }
     // get all Awareness Session Activites ajax request Table Data
     public function fetchAllCallsActivity()
     {
         $userId = Auth::id();
         $userRoleId = Auth::user()->role_id;
         $currentDate = Carbon::now()->toDateString();
         if ($userRoleId == 12) {
             $activities = HelplineActivity::get();
         } else {
             $activities = HelplineActivity::where('user_id', $userId)->where('date', $currentDate)->get();
         }
 
         $output = '';
         if($activities->count()>0){
             $output .= ' <table id="dataTableExample" class="table table-striped table-bordered" style="width:100%; font-size: small;">
             <thead style="background-color: #6571ff;">
               <tr>
                 <th style="color: #f8f8ff;">Title</th>
                 <th style="color: #f8f8ff;">Date</th>
                 <th style="color: #f8f8ff;">Created By</th>
                 <th style="color: #f8f8ff;">User</th>
               </tr>
             </thead>
             <tbody>';
             foreach ($activities as $activity) {
             
                 $output .= '<tr >
                 <td style="font-size: 12px; color: #444444;"><a href="' . route('view-helplinecall-activity', ['id' => $activity->id]) . '" target="_self" class="activity-link">
                 <i class="fas fa-hand-point-right fa-lg" style="margin-right: 5px;"></i>&nbsp;' . $activity->title . '
                     </a></td>
   
                 <td style="font-size: 12px; color: #444444;" data-sort="' . \Carbon\Carbon::parse($activity->date)->format('Y-m-d') . '">
                 ' . \Carbon\Carbon::parse($activity->date)->format('d-m-Y') . '
                     </td>
                 <td style="font-size: 12px; color: #444444;" >' . $activity->userdata->name. '</td>
                 <td style="font-size: 12px; color: #444444;" >' . $activity->user->name. '</td>';
 
             }
             $output .= '</tbody></table>';
             echo $output;
         } else {
             echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
         }
     }
     public function viewHelplineCallsActivity($id)
     {
        $activityCalls = HelplineCall::where('activities_id', $id)->get();
        $addresses = PresentAddress::get();
        $issueResponses = DB::table('helpline_issueresponse')->get();
        $activityCalls->transform(function ($call) {
            $call->gender = $call->gender === 0 ? 'Male' : ($call->gender === 1 ? 'Female' : 'Unknown');
            $call->card_holder = $call->card_holder === 0 ? 'POR' : ($call->card_holder === 1 ? 'Non-POR' : 'Unknown');
            return $call;
        });
         $helplinecalls = DB::table('helpline_calls')
                         ->select(
                             'helpline_calls.call_datetime',
                             'helpline_calls.caller_name',
                             'helpline_calls.father',
                             'helpline_calls.gender',
                             'helpline_calls.family_size',
                             'helpline_calls.card_holder',
                             'helpline_calls.pre_address',
                             'helpline_calls.address_coo',
                             'helpline_calls.arrival_date',
                             'helpline_calls.contact',
                             'helpline_calls.issue',
                             'helpline_calls.response_alac',
                             'helpline_calls.respondent',
                             'helpline_calls.user_id',
                         )
                         ->where('helpline_calls.activities_id', $id) 
                         ->get();
 
        //  $data = Activities::find($id);
        //  $title = strtoupper($data->title);
        //  $genders = DB::table('genders')->get();
        //  $districts = DB::table('districts')->get();
      // Count male and female hosts separately
         
         return view('employee.helpline.calls-table', [
         'helplinecalls' => $helplinecalls,
         "id"=>$id,
         'activityCalls'=>$activityCalls,
         'issueResponses'=>$issueResponses,
         'addresses' =>$addresses
         ]);
        
     }
     public function storingCallers(Request $request)
     {
         $user_id = Auth::id();
         $helpline_activtityid = $request->input('id');
         $activity = DB::table('helpline_activities')
             ->where('helpline_activities.id', $helpline_activtityid)
             ->first(); // Using first() assuming you expect only one activity
 
         if ($activity) {
             $activtiyDate = $activity->date;
             $activtiyCreatedBy = $activity->data_user;
             $activityLoggedInUser = $activity->user_id;
         }
         // Define custom error messages for size rule
         $customMessages = [
             'identity.size' => 'Must be: XXXXX-XXXXXXX-X.'
         ];
         // Validate the request
         $validator = Validator::make($request->all(), [
             'contact' => ['required'],
             'familysize' => ['required'],
             'caller_name' => ['required'],
         ], $customMessages);
 
         if ($validator->fails()) {
             return response()->json([
                 'success' => false,
                 'errors' => $validator->errors()->all() // Send all validation errors
             ]);
         }
 
         try{
             $helplineCaller =[
                 'call_datetime'=>now()->addHours(5),
                 'caller_name'=>$request->caller_name,
                 'father'=>$request->father,
                 'gender'=>$request->gender,
                 'family_size'=>$request->familysize,
                 'adultmember'=>$request->adultmember,
                 'card_holder'=>$request->card_holder,
                 'pre_address'=>$request->present,
                 'address_coo'=>$request->coo,
                 'contact'=>$request->contact,
                 'issue'=>$request->issue,
                 'response_alac'=>$request->response,
                 'respondent'=>$request->calltype,
                 'user_id'=>$user_id,
                 'activities_id'=>$helpline_activtityid,
             ];
             HelplineCall::create($helplineCaller);
             return response()->json(['success' => true, 'message' => 'Caller added successfully']);
         }
         catch (Exception $e) {
             return response()->json([
                 'success' => false,
                 'message' => 'Failed to add data. An unexpected error occurred.'
             ]);
         }
         
     }
    //  getResponses
    public function getResponses(Request $request)
    {
        $issueId = $request->input('issueId');
        $responses = DB::table('helpline_issueresponse')
                ->where('id', $issueId)
                ->get();
        return response()->json($responses);
    }
}
