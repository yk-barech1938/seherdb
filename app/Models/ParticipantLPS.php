<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
class ParticipantLPS extends Model
{
    use HasFactory;
    public static function getAwarenessParticipants()
    {
            $awarenessSessions = DB::table('participant_l_p_s')
            ->join('genders', 'genders.id', '=', 'participant_l_p_s.gender_id')
            ->join('camps', 'camps.id', '=', 'participant_l_p_s.camp')
            ->join('districts', 'districts.id', '=', 'participant_l_p_s.district_id')
            ->join('activities', 'activities.id', '=', 'participant_l_p_s.activities_id')
            ->where('code','LIKE','LPS%')
            ->select(
                DB::raw("CONCAT(UPPER(SUBSTRING(participant_l_p_s.name, 1, 1)), LOWER(SUBSTRING(participant_l_p_s.name, 2))) AS name"),
                DB::raw("CONCAT(UPPER(SUBSTRING(participant_l_p_s.father, 1, 1)), LOWER(SUBSTRING(participant_l_p_s.father, 2))) AS father"),
                'genders.gender',
                // 'participant_l_p_s.identity_code',
                DB::raw("CASE WHEN participant_l_p_s.identity_code = 'undocument' THEN '' ELSE participant_l_p_s.identity_code END AS identity_code"),
                DB::raw("CASE WHEN participant_l_p_s.identity_code = 'undocument' THEN 'Undocumented' ELSE participant_l_p_s.document_no END AS document_no"),
                DB::raw("CASE WHEN participant_l_p_s.contact = 'N/A' THEN '' ELSE participant_l_p_s.contact END AS contact"), // Replace 'N/A' with empty string
                'districts.district',
                'camps.title as camp', 
                // DB::raw("CONCAT(UPPER(SUBSTRING(camps.title, 1, 1)), LOWER(SUBSTRING(camps.title, 2))) AS camp"),
                DB::raw("DATE_FORMAT(participant_l_p_s.session_date, '%d/%m/%Y') as formatted_session_date"), // Formatting the session_date field
                'activities.title as Activity', 
            )->orderBy('participant_l_p_s.activities_id', 'asc') ->get();
            return $awarenessSessions;
    }
    public static function getCbplParticipants()
    {
            $awarenessSessions = DB::table('participant_l_p_s')
            ->join('genders', 'genders.id', '=', 'participant_l_p_s.gender_id')
            ->join('camps', 'camps.id', '=', 'participant_l_p_s.camp')
            ->join('districts', 'districts.id', '=', 'participant_l_p_s.district_id')
            ->join('users', 'users.id', '=', 'participant_l_p_s.user_id')
            ->where('code','LIKE','CBPL%')
            ->select(
                DB::raw("CONCAT(UPPER(SUBSTRING(participant_l_p_s.name, 1, 1)), LOWER(SUBSTRING(participant_l_p_s.name, 2))) AS name"),
                DB::raw("CONCAT(UPPER(SUBSTRING(participant_l_p_s.father, 1, 1)), LOWER(SUBSTRING(participant_l_p_s.father, 2))) AS father"),
                'genders.gender',
                DB::raw("CASE WHEN participant_l_p_s.identity_code = 'undocument' THEN '' ELSE participant_l_p_s.identity_code END AS identity_code"),
                DB::raw("CASE WHEN participant_l_p_s.identity_code = 'undocument' THEN 'Undocumented' ELSE participant_l_p_s.document_no END AS document_no"),
                DB::raw("CASE WHEN participant_l_p_s.contact = 'N/A' THEN '' ELSE participant_l_p_s.contact END AS contact"), // Replace 'N/A' with empty string
                'districts.district',
                'camps.title as camp', 
                'users.name as user', 
                DB::raw("DATE_FORMAT(participant_l_p_s.session_date, '%d/%m/%Y') as formatted_session_date"), // Formatting the session_date field
                'participant_l_p_s.activities_id',
            )->orderBy('participant_l_p_s.activities_id', 'asc') ->get();
            return $awarenessSessions;
    }
    protected $fillable =[
        'name',
        'father',
        'gender_id',
        'document_no',
        'contact',
        'district_id',
        'camp',
        'conducted',
        'issue',
        'services_provided_lc',
        'remarks',
        'cnic',
        'venue',
        'designation',
        'department',
        'address_pakistan',
        'address_afghanistan',
        'location',
        'banners',
        'user_id',
        'activities_id',
        'session_date',
        'nationality', // New field
        'identity_code', // New field
        'code',
    ];
    // Define the BelongsTo relationship with the Gender model
    public function gender()
    {
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    // Define the BelongsTo relationship with the District model
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function activity()
    {
        return $this->belongsTo(Activities::class);
    }
}
