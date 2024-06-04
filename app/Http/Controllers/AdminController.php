<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // admin dashboard view
    public function AdminDashboard(){
        return view('admin.index');
    }
    
     /**
     *  AgentLogout we can also use a default method in the  AuthenticatedSessionController name destroy
     * Destroy an authenticated session.
     * (Request $request) : RedirectResponse remove the RedirectResponse because issueing if issuing remove it
     */
    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
    // login view just AdminProfile
    public function AdminLogin(){
        return view('admin.admin_login');
    }
    public function AdminProfile(){
       $id = Auth::user()->id;
       $profileData = User::find($id);
       return view('admin.admin_profile_view',compact('profileData'));
    }
    public function AdminProfileStore(Request $request){
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['photo'] =$filename;
        }
        $data->save();
        $notification = array(
            'message'=>'Admin Profile Upaded Successfully',
            'alert-type'=>'success'
        );
        // return redirect()->back(); 
        return redirect()->back()->with($notification);
    }
    public function AdminChangePassword(){
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password',compact('profileData'));
    }
    public function AdminUpdatePassword(Request $request){
        // validation 
        $request->validate([
            'old_password'=> 'required',
            'new_password'=> 'required|confirmed'
        ]);
        // match the old Pasword
        if(!Hash::check($request->old_password,auth::user()->password)){
            $notification = array(
                'message'=>'Old Password Does not Match!',
                'alert-type'=>'error'
            );
            return back()->with($notification);
        }
        // update the new password
        User::whereId(auth()->user()->id)->update([
            'password'=>Hash::make($request->new_password)
        ]);
        $notification = array(
            'message'=>'Password Change Successfully',
            'alert-type'=>'success'
        );
        return back()->with($notification);
    }
}
