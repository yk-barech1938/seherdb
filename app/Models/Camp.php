<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'district_id'];

    // Define the reverse relationship with CommBasedParaLegal model
    public function Activites()
    {
        return $this->hasMany(Activities::class, 'camp_id');
    }
}
