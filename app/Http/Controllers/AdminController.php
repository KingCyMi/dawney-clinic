<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Mail\UserPassword;
use App\Owner;
use App\Pet;
use App\PetRecord;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use Nexmo\Laravel\Facade\Nexmo;

class AdminController extends Controller{


    public function dashboard(){

        $appointments = Appointment::where('appointment_start', '>=', Carbon::now())->get()->groupBy(function($q){
            return $q->appointment_start->day;
        });

        return view('admin.dashboard', compact('appointments'));
    }

    public function appointmentList(){
        $appointments = Appointment::where('appointment_start', '>=', Carbon::now())->latest()->paginate(20);

        return view('admin.appointment.list', compact('appointments'));
    }

    public function appointmentRemind($id){
        $appointment = Appointment::findOrFail($id);

        $number = $appointment->user->owner->contact_number;

        $number = substr($number, 1);

        $number = '63'. $number;

        Nexmo::message()->send([
            'to'   => $number,
            'from' => '639999385515',
            'text' => 'You have an appointmnet in Dawney Animal Clinic at '. $appointment->appointment_start->format('h:i a') . ' ' . $appointment->appointment_start->toDateString()
        ]);

        return redirect()->route('admin.appointment.list')->with([
            'status' => true,
            'message' => 'Successfully Notified'
        ]);
    }

    public function userList(){
        $users = User::with('owner')->paginate(20);

        return view('admin.user.list', compact('users'));
    }

    public function userUpdate($id){
        $user = User::findOrFail($id);

        return view('admin.user.update', compact('user'));
    }

    public function userUpdatePost(Request $request, $id){
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'contact_number' => ['required', 'string', 'max:11', 'regex:/^(09)\d{9}$/'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,id,'. $user->id],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // dd($request->is_admin);

        $user->update([
            'email' => $request->email,
            'is_admin' => $request->is_admin ? $request->is_admin : false
        ]);

        $user->owner->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_number' => $request->contact_number,
            'address' => $request->address
        ]);

        return redirect()->route('admin.user.update', $user->id)->with([
            'status' => true,
            'message' => 'Successfully updated'
        ]);
    }


    public function patientList(){
        $pets = Pet::paginate(20);

        return view('admin.patient.list', compact('pets'));
    }

    public function patientCreate(){
        return view('admin.patient.create');
    }

    public function patientCreateStore(Request $request){
        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'color' => 'required',
            'species' => 'required',
            'date_birth' => 'required|date',
            'first_name' => 'required',
            'last_name' => 'required',
            'contact_number' => ['required', 'string', 'max:11', 'regex:/^(09)\d{9}$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $password = Str::random(10);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($password)
        ]);

        $owner = Owner::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'contact_number' => $request->contact_number,
            'address' => $request->address
        ]);

        $pet = Pet::create([
            'owner_id' => $owner->id,
            'name' => $request->name,
            'gender' => $request->gender,
            'color' => $request->color,
            'species' => $request->species,
            'birth_date' => Carbon::parse($request->date_birth),
        ]);


        Mail::to($user->email)->send(new UserPassword([
            'email' => $user->email,
            'password' => $password
        ]));

        return redirect()->route('admin.patient.create')->with([
            'status' => true,
            'message' => 'Successfully added patient'
        ]);

    }

    public function patientUpdate($id){
        $patient = Pet::findOrFail($id);

        return view('admin.patient.update', compact('patient'));
    }

    public function patientUpdatePost(Request $request, $id){
        $pet = Pet::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'color' => 'required',
            'species' => 'required',
            'date_birth' => 'required|date'
        ]);

        $pet->update($request->except('_TOKEN', 'date_birth'));

        $pet->update([
            'birth_date' => Carbon::parse($request->date_birth),
        ]);

        return redirect()->route('admin.patient.update', $pet->id)->with([
            'status' => true,
            'message' => 'Successfully updated'
        ]);

    }

    public function patientView($id){
        $patient = Pet::findOrFail($id);

        return view('admin.patient.view', compact('patient'));
    }

    public function patientRecordCreate($id){

        $patient = Pet::findOrFail($id);

        return view('admin.patient.recordCreate', compact('patient'));

    }

    public function patientRecordCreatePost(Request $request, $id){
        $patient = Pet::findOrFail($id);

        $request->validate([
            'procedure' => 'required',
            'temperature' => 'required|numeric',
            'weight' => 'required|numeric'
        ]);

        PetRecord::create([
            'pet_id' => $patient->id,
            'procedure' => $request->procedure,
            'temperature' => $request->temperature,
            'weight' => $request->weight,
            'comments' => $request->comment
        ]);

        return redirect()->route('admin.patient.record.create', $id)->with([
            'status' => true,
            'message' => 'Successfully added new record'
        ]);

    }

    public function patientRecordView($id, $rId){

        $record = PetRecord::where('id', $rId)->where('pet_id', $id)->firstOrFail();

        return view('admin.patient.recordView', compact('record'));

    }

    // patients - create / update
    // appointment - list  (callendar)
    // users/owner - update d
    //

}
