<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Pet;
use Carbon\Carbon;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Http\Request;

class AppointmentController extends Controller{

    public function create(){
        return view('appointment');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'color' => 'required',
            'breed' => 'required',
            'species' => 'required',
            'date_birth' => 'required|date',
            'appointment_time' => 'required|date',
            'message' => 'nullable',
        ]);


        $start_time = Carbon::parse($request->appointment_time);
        $end_time = Carbon::parse($request->appointment_time)->addMinutes(30);

        if($start_time->lt(Carbon::now())){
            return redirect()->route('appointment.create')->with([
                'status' => false,
                'message' => 'Time must be in the future not in the past'
            ]);
        }

        $check = Appointment::whereDate('appointment_start', '=', $start_time)->whereTime('appointment_end', '>=', $start_time->toTimeString())
            ->whereTime('appointment_start', '<=', $end_time->toTimeString())
            ->first();

        if($check){
            return redirect()->route('appointment.create')->with([
                'status' => false,
                'message' => 'Conflicts with another appointment please adjust the time. Thanks'
            ]);
        }

        $weekMap = [
            1 => 'MO',
            2 => 'TU',
            3 => 'WE',
            4 => 'TH',
            5 => 'FR',
            6 => 'SA',
        ];

        if(!in_array($start_time->dayOfWeek, array_keys($weekMap))){
            return redirect()->route('appointment.create')->with([
                'status' => false,
                'message' => 'The clinic is closed in sunday please choose other day'
            ]);
        }

        if(!($start_time->hour >= 8 && $start_time->hour <= 17)){
            return redirect()->route('appointment.create')->with([
                'status' => false,
                'message' => 'The clinic is open at 8AM to 5PM'
            ]);
        }

        $user = $request->user();


        $pet = Pet::create([
            'owner_id' => $user->owner->id,
            'name' => $request->name,
            'gender' => $request->gender,
            'breed' => $request->breed,
            'color' => $request->color,
            'species' => $request->species,
            'birth_date' => Carbon::parse($request->date_birth),
        ]);

        Appointment::create([
            'user_id' => $user->id,
            'pet_id' => $pet->id,
            'appointment_start' => $start_time,
            'appointment_end' => $end_time,
            'reason' => $request->message
        ]);

        $number = $user->owner->contact_number;

        $number = substr($number, 1);

        $number = '63'. $number;

        Nexmo::message()->send([
            'to'   => $number,
            'from' => '639999385515',
            'text' => 'You have successfully booked your appointment in Dawney Animal Clinic at '. $start_time->format('h:i a') . ' ' . $start_time->toDateString()
        ]);

        return redirect()->route('appointment.create')->with([
            'status' => true,
            'message' => 'Your appointment has been booked!'
        ]);

    }

}
