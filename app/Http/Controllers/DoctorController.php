<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        $selectedSpecialty = $request->input('specialty');
        $search = $request->input('search');

        $specialties = Doctor::distinct()->pluck('specialty');

        $doctors = Doctor::with('schedules')
            ->when($selectedSpecialty, function ($query, $specialty) {
                return $query->where('specialty', $specialty);
            })
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%");
            })
            ->get();

        return view('doctor', compact('doctors', 'specialties', 'selectedSpecialty'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date',
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        // 1. Calculate Queue Number for this specific doctor and date
        $queueNumber = Appointment::where('schedule_id', $request->schedule_id)
            ->where('appointment_date', $request->appointment_date)
            ->count() + 1;

        // 2. Create the Appointment
        Appointment::create([
            'user_id' => Auth::id(),
            'schedule_id' => $request->schedule_id,
            'name' => $request->name,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
            'queue_number' => $queueNumber,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
            'taken_by' => 'Patient Self-Registration',
        ]);

        return redirect()->route('doctors.index')->with('success', "Booking successful! Your Queue Number is #$queueNumber");
    }
}
