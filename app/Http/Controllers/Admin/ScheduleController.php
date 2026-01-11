<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with('doctor');
        $query->when($request->doctor_id, function ($q) use ($request) {
            return $q->where('doctor_id', $request->doctor_id);
        });
        $query->when($request->filled('day_filter'), function ($q) use ($request) {
            return $q->where('date', $request->day_filter);
        });

        $schedules = $query->orderBy('date', 'asc')->get();
        $doctors = Doctor::all();

        return view('admin.schedule', compact('schedules', 'doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required',
            'date' => 'required', // This is now the Day of Week (0-6)
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'max_queue' => 'required|integer',
        ]);

        Schedule::create($request->all());
        return redirect()->back()->with('success', 'Weekly schedule added.');
    }

    public function update(Request $request, Schedule $schedule)
    {
        $schedule->update($request->all());
        return redirect()->route('admin.schedules.index')->with('success', 'Schedule updated.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->back()->with('success', 'Schedule removed.');
    }
}