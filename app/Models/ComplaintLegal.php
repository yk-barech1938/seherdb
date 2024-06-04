<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintLegal extends Model
{
    use HasFactory;
    protected $table = 'complaint_legal';
    protected $fillable = ['description', 'user_id', 'imagepath', 'supervisor', 'date'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
