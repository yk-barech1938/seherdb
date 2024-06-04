<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activities extends Model
{

    use HasFactory;
    protected $fillable = 
    [
        'title', 'district_id', 'user_id','date','document_path','movs_name',
        'camp_id','project_id','designation_id','proj_participantsid','teammembers',
    ];
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
    public function camp()
    {
        return $this->belongsTo(Camp::class, 'camp_id');
    }
    public function username()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function images()
    {
        return $this->hasMany(Images::class);
    }
    public function participants()
    {
        return $this->hasMany(ParticipantLPS::class);
    }
    public function optionalImages()
    {
        return $this->hasMany(Images::class);
    }



}
