<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = ['user_id', 'pet_id', 'appointment_start', 'appointment_end', 'reason'];

    protected $dates = ['appointment_start', 'appointment_end'];

    public function pet(){
        return $this->belongsTo(Pet::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
