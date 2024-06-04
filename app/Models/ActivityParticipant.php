<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityParticipant extends Model
{
    use HasFactory;
    protected $fillable = [
        'participants_name',
        'designation_name',
        'activity_id',
        'data_field',
    ];

    public function activity()
    {
        return $this->belongsTo(Activities::class);
    }
}
