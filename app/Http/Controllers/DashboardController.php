<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment; // Assuming you have this model
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $latestActive = Appointment::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'on_service'])
            ->orderBy('appointment_date', 'asc')
            ->with(['schedule.doctor'])
            ->first();

        $stats = [
            'upcoming_count' => Appointment::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'on_service'])->count(),
            'total_history' => Appointment::where('user_id', $user->id)
                ->where('status', 'completed')->count(),
        ];

        $recentHistory = Appointment::where('user_id', $user->id)
            ->where('status', 'completed')
            ->latest()
            ->with(['schedule.doctor'])
            ->take(3)
            ->get();

        return view('dashboard', compact('latestActive', 'stats', 'recentHistory'));
    }
}
