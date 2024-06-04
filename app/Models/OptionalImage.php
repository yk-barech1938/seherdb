<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionalImage extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'activities_id'];
    public function activity()
    {
        return $this->belongsTo(Activities::class);
    }
}
