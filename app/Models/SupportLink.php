<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportLink extends Model
{
 protected $fillable = ['supporter_id','patient_id'];
 public function supporter(){ return $this->belongsTo(User::class,'supporter_id'); }
 public function patient(){ return $this->belongsTo(User::class,'patient_id'); }
}
