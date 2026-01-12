<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['schedule.doctor']);

        // Filters
        if ($request->doctor_id) {
            $query->whereHas('schedule', fn($q) => $q->where('doctor_id', $request->doctor_id));
        }

        // NEW: Filter by specific schedule
        if ($request->schedule_id) {
            $query->where('schedule_id', $request->schedule_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $appointments = $query->latest()->get();
        $doctors = Doctor::all();

        // Get schedules with doctor names for the filter dropdown
        $schedules = Schedule::with('doctor')->get();

        $stats = [
            'total' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'on_service' => Appointment::where('status', 'on_service')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
        ];

        return view('admin.appointment', compact('appointments', 'doctors', 'schedules', 'stats'));
    }

    public function getSchedules(Request $request)
    {
        $schedules = Schedule::with('doctor')
            ->where('date', $request->day)
            ->get();

        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date',
            'name' => 'required|string',
            'age' => 'required|integer',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        // Calculate queue for specific doctor on specific date
        $queue = Appointment::where('schedule_id', $request->schedule_id)
            ->whereDate('appointment_date', $request->appointment_date)
            ->count() + 1;

        Appointment::create([
            'user_id' => Auth::id(),
            'schedule_id' => $request->schedule_id,
            'name' => $request->name,
            'age' => $request->age,
            'phone' => $request->phone,
            'email' => $request->email,
            'queue_number' => $queue,
            'appointment_date' => $request->appointment_date,
            'status' => 'pending',
            'taken_by' => Auth::user()->name,
        ]);

        return redirect()->back()->with('success', 'Appointment #' . $queue . ' recorded successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status updated.');
    }
}
