<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HelplineActivity extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'data_user',
        'date',
        'user_id',
        'description',
    ];
    
    public function calls()
    {
        return $this->hasMany('App\HelplineCall', 'helpline_activity_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function userdata()
    {
        return $this->belongsTo(User::class, 'data_user');
    }
}
