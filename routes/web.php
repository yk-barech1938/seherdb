<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AwarenessSessionController;
use App\Http\Controllers\CommBasedParaLegalController;
use App\Http\Controllers\LegalCampController;
use App\Http\Controllers\LegalSeriveController;
use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\ParticipantLPSController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HelplineCallsController;
use Illuminate\Support\Facades\Auth;
use App\Models\Camp;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/cleareverything', function () {
    $clearcache = \Artisan::call('cache:clear');
    echo "Cache cleared<br>";

    $clearview = \Artisan::call('view:clear');
    echo "View cleared<br>";

    $clearconfig = \Artisan::call('config:cache');
    echo "Config cleared<br>";
    
});
Route::redirect('/','/login');

Route::get('/dashboard', 'App\Http\Controllers\EmployeeController@employeeDashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
// Admin Group Middleware admin.update.password
Route::middleware(['auth','role:admin'])->group(function(){
    // for admin dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');
    // Awarness Session CRUD
    Route::get('/admin/legal-service/awareness', [AwarenessSessionController::class, 'indexAdmin'])->name('admin.legal.awareness');
    Route::get('/admin/legal/awareness',[AwarenessSessionController::class,'fetchAll'])->name('admin.fetchAllAwareness');
    // Awarness Session Edit and Update
    Route::get('/admin/legal/awarenessedit',[AwarenessSessionController::class,'awarenessEdit'])->name('admin.awarenessEdit');
    Route::post('/admin/legal/awarenessupdate',[AwarenessSessionController::class,'awarenessUpdate'])->name('admin.awarenessUpdate');

});
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::get('/user/logout', [EmployeeController::class, 'EmployeeLogout'])->name('user.logout');
Route::get('/legal-awareness',[AwarenessSessionController::class,'AwarenessSession'])->name('employee.legal.awareness');
// Coomunity Based Para Legal Service Routes
Route::get('/legal-cbpl',[CommBasedParaLegalController::class,'index'])->name('employee.legal.cbpl');
Route::post('/storing',[CommBasedParaLegalController::class,'storing'])->name('storing');
Route::get('/legal-cbpl-fetch-all',[CommBasedParaLegalController::class,'fetchAllCBPL'])->name('fetchCBPL');
Route::post('/cbpl-activity/store', [CommBasedParaLegalController::class, 'store'])->name('cbplactivity.store');
Route::post('/cbpl/search', [CommBasedParaLegalController::class, 'searchCbplActivities'])->name('search.cbplactivities');
// fetch CBPL by district Beneficiieries
Route::get('/getByDistrictBeneficiaryCbpl/{district_id}', [CommBasedParaLegalController::class,'getByDistrictBeneficiaryCbpl']);
// Fetch awareness session activities by district
Route::get('/fetch-cbpl/{districtId}', [CommBasedParaLegalController::class, 'fetchCbplByDistrict'])
    ->name('fetchCbplByDistrict');
Route::get('/view-cbpl-activity/{id}',[CommBasedParaLegalController::class, 'viewCbplActivity'])->name('view-cbpl-activity');    
Route::post('/activities/cbplstoring',[CommBasedParaLegalController::class,'storing'])->name('cbpl.participants');
Route::get('cbpl-excel', [CommBasedParaLegalController::class, 'exportExcel'])->name('cbplexcel.export');

// LPS Legal Camp Routes
Route::get('/legal-camp',[LegalCampController::class,'index'])->name('employee.legal.camp');
Route::get('/legal-camp-fetch-all',[LegalCampController::class,'fetchAllLegalCamp'])->name('fetchLegalCamp');
Route::post('/legal-camp/storeactivity', [LegalCampController::class, 'storeActivity'])->name('campactivity.store');
Route::post('/legalcamp/search', [LegalCampController::class, 'searchLegalCampActivities'])->name('search.campactivities');
Route::get('/view-legalcamp/{id}',[LegalCampController::class, 'viewLegalCampBeneficiary'])->name('view-camp-beneficiary'); 
Route::post('/activities/legalcampstoring',[LegalCampController::class,'storing'])->name('legalcampstore.participants');  

// routes/web.php
Route::post('/fetch-camps', [ActivitiesController::class, 'fetchCamps'])->name('fetch.camps');
// Show the activity creation form
Route::get('/activities/create', [ActivitiesController::class, 'showForm'])->name('activities.create');

// Store the activity and associated images
// Route::post('/activities/store', [ActivitiesController::class, 'store'])->name('activities.store');
Route::post('/activities/store', [ActivitiesController::class, 'store'])->name('activities.store');
Route::get('/generate-pdf/{id}',[ActivitiesController::class, 'generatePDF'])->name('generate-pdf');
Route::get('/view-awareness-activity/{id}',[ParticipantLPSController::class, 'viewAwarenessActivity'])->name('view-awareness-activity');

Route::post('/activities/awarenessstoring',[ParticipantLPSController::class,'storing'])->name('awareness.participants');
// Fetch the Awareness Session by District
Route::get('/getDistrictGenderCounts/{district_id}', [ParticipantLPSController::class,'getDistrictGenderCounts']);
// fetch all awareness session jquery
Route::get('/legalawarenesssession',[ActivitiesController::class,'fetchAllAwarenessSession'])->name('fetchAwarenessSession');
// Fetch awareness session activities by district
Route::get('/fetch-awareness-session/{districtId}', [ActivitiesController::class, 'fetchAwarenessSessionByDistrict'])
    ->name('fetchAwarenessSessionByDistrict');
Route::post('/getTeamMembers',[ActivitiesController::class,'getTeamMembers'])->name('get-teammember');
    // Complaint Legal Protection Service
Route::get('/legal/complaint', [ComplaintController::class, 'create'])->name('complaint.create');
Route::post('/legal/complaint/store', [ComplaintController::class, 'storeLps'])->name('complaint.lps.store');


// EXCEL Export
Route::get('excel-export', [ParticipantLPSController::class, 'exportExcel'])->name('excel.export');
Route::post('/awareness/search', [ActivitiesController::class, 'searchAwarenessActivities'])->name('search.awrenessactivities');

// ALAC Helpline Calls
Route::get('/helpline-calls',[HelplineCallsController::class,'index'])->name('employee.helplinecalls');
Route::post('/helpactivity/store', [HelplineCallsController::class, 'storing'])->name('helpactivity.store');
Route::get('/fetchhelplineactivity',[HelplineCallsController::class,'fetchAllCallsActivity'])->name('fetchhelpline.activity');
Route::get('/view-helplinecall-activity/{id}',[HelplineCallsController::class, 'viewHelplineCallsActivity'])->name('view-helplinecall-activity');
Route::post('/activities/helplinecallers',[HelplineCallsController::class,'storingCallers'])->name('helplinecalls.callers');
Route::get('/get-responses', [HelplineCallsController::class, 'getResponses']);
Route::get('/checkActivityExists', [HelplineCallsController::class, 'checkActivityExists']);
//  Agent Routes Here
Route::middleware(['auth','role:agent'])->group(function(){
    // for admin dashboard
    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');

});



