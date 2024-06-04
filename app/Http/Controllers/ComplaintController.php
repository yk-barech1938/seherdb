<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\ComplaintLegal;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
class ComplaintController extends Controller
{
    public function create()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('complaints.create',compact('profileData'));
        // return view('complaints.create');
    }
    public function storeLps(Request $request)
    {
        try {
        // \Log::info('Request Data:', $request->all());
            $id = Auth::user()->id;
            $date = Carbon::now()->toDateString();
            $request->validate([
                'description' => 'required',
                'fileToUpload' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust max file size as needed
            ]);
             // Debugging uploaded file
        if ($request->hasFile('fileToUpload')) {
            $file = $request->file('fileToUpload');
            // \Log::info('Uploaded File Name: ' . $file->getClientOriginalName());
            // \Log::info('Uploaded File Extension: ' . $file->getClientOriginalExtension());
            // \Log::info('Uploaded File Size: ' . $file->getSize());
            // \Log::info('Uploaded File Mime Type: ' . $file->getMimeType());
        } else {
            // \Log::info('No file uploaded.');
        }

            $description = $request->input('description');
            $imagePath = $request->file('fileToUpload')->store('complaints');

            ComplaintLegal::create([
                'description' => $description,
                'user_id'=>$id,
                'imagepath' => $imagePath,
                'supervisor'=>'14',
                'date'=>$date
            ]);

            return redirect()->back()->with('success', 'Complaint submitted successfully.');
        } catch (\Exception $e) {
            \Log::error('Error: ' . $e->getMessage());
            // Log the exception or handle it as needed
            return redirect()->back()->with('error', 'Failed to submit complaint. Please try again later.');
        }

       

    }
}
