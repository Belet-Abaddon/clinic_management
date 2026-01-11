<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        // Fetch appointments for the logged-in user
        // We load 'schedule.doctor' to get the doctor's name and specialty
        $appointments = Appointment::with(['schedule.doctor'])
            ->where('user_id', Auth::id())
            ->orderBy('appointment_date', 'desc')
            ->get();

        // Calculate simple stats
        $total = $appointments->count();
        $upcoming = $appointments->where('status', 'pending')->count();
        $completed = $appointments->where('status', 'completed')->count();

        return view('appointment', compact('appointments', 'total', 'upcoming', 'completed'));
    }

    public function cancel($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())->findOrFail($id);
        
        // Only allow cancellation if still pending
        if ($appointment->status === 'pending') {
            $appointment->delete();
            return back()->with('success', 'Appointment cancelled successfully.');
        }

        return back()->with('error', 'Cannot cancel an appointment that is already in progress or completed.');
    }
}