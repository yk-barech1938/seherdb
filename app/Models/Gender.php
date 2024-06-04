<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;
     // Define the reverse relationship with CommBasedParaLegal model
     public function commBasedParaLegals()
     {
         return $this->hasMany(CommBasedParaLegal::class, 'gender_id');
     }
     // Define the reverse relationship with CommBasedParaLegal model
     public function AwarenessSession()
     {
         return $this->hasMany(AwarenessSession::class, 'gender_id');
     }
}
