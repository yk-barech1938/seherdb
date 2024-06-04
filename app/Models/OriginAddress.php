<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OriginAddress extends Model
{
    use HasFactory;
    protected $table = 'origin_addresses';
    protected $fillable = [
        'address_coo', 
    ];
}
