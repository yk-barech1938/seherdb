<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommBasedParaLegal extends Model
{

    use HasFactory;
    protected $fillable =[
        'name',
        'father',
        'gender_id',
        'document_no',
        'district_id',
        'camp',
        'session_date',
        'conducted'
    ];
     // Define the BelongsTo relationship with the Gender model
     public function gender()
     {
         return $this->belongsTo(Gender::class, 'gender_id');
     }
 
     // Define the BelongsTo relationship with the District model
     public function district()
     {
         return $this->belongsTo(District::class, 'district_id');
     }
}
