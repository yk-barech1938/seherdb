<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    public function Activites()
    {
        return $this->hasMany(Activities::class, 'district_id');
    }
     // Define the reverse relationship with CommBasedParaLegal model
     public function commBasedParaLegals()
     {
      
         return $this->hasMany(CommBasedParaLegal::class, 'district_id');
     }
     public function AwarenessSession()
     {
         return $this->hasMany(AwarenessSession::class, 'district_id');
     }

     
}
