<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // 1. Stats Calculation
        $totalAppointments = Appointment::count();
        $activeDoctors = Doctor::count();
        $pendingCount = Appointment::where('status', 'pending')->count();
        $todayCount = Appointment::whereDate('created_at', $today)->count();

        // 2. Growth Calculation
        $thisMonth = Appointment::whereMonth('created_at', Carbon::now()->month)->count();
        $lastMonth = Appointment::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $growth = $lastMonth > 0 ? (($thisMonth - $lastMonth) / $lastMonth) * 100 : 0;

        // 3. Fetch Admin List (Latest 5)
        // Adjust 'role' or 'is_admin' based on your actual database column
        $admins = User::where('role', 1)->latest()->take(5)->get();

        // 4. Fetch Doctor List (Latest 5)
        $doctorList = Doctor::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalAppointments',
            'activeDoctors',
            'pendingCount',
            'todayCount',
            'growth',
            'admins',
            'doctorList'
        ));
    }
}