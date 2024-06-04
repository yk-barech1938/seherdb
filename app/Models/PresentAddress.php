<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentAddress extends Model
{
    use HasFactory;
    protected $table = 'present_addresses';
    protected $fillable = [
        'address',
    ];
}
