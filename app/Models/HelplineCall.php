<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelplineCall extends Model
{
    use HasFactory;
    protected $fillable = [
        'call_datetime',
        'caller_name',
        'father',
        'gender',
        'family_size',
        'card_holder',
        'pre_address',
        'address_coo',
        'arrival_date',
        'contact',
        'issue',
        'response_alac',
        'respondent',
        'adultmember',
        'remarks',
        'user_id',
        'activities_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function activity()
    {
        return $this->belongsTo('App\HelplineActivity', 'helpline_activity_id');
    }
    public function userdata()
    {
        return $this->belongsTo(User::class, 'data_user');
    }
}
