<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proj_Participants extends Model
{
    use HasFactory;
    protected $table = 'proj_participants';
    protected $fillable = ['participant_name', 'project_id', 'designation_id'];
    public function project()
    {
        return $this->belongsTo(Projects::class, 'project_id');
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
}
