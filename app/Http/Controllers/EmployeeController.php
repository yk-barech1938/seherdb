<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\ComplaintLegal; 

class EmployeeController extends Controller
{
    
    public function employeeDashboard()
    {
        $user_id = Auth::id();
        if ($user_id == '15') {
            $complaints = ComplaintLegal::with('user')->get(); // Get all complaints with user details for agents
        } else {
            // Get only complaints associated with the authenticated user
            $complaints = ComplaintLegal::where('user_id', $user_id)->with('user')->get();
        }
        return view('employee.index', compact('complaints')); // Pass the $complaints variable to the view
    }
     // login view just AdminProfile
     public function EmployeeLogin(){
        return view('/');
    }
            // $complaints = DB::table('complaint_legal')->get();
     /**
     *  AgentLogout we can also use a default method in the  AuthenticatedSessionController name destroy
     * Destroy an authenticated session.
     * (Request $request) : RedirectResponse remove the RedirectResponse because issueing if issuing remove it
     */
    public function EmployeeLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
