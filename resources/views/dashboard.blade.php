@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900 uppercase tracking-tight">Patient Portal</h1>
            <p class="text-slate-500 text-sm">Welcome back, {{ Auth::user()->name }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                
                @if($latestActive)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-blue-600 p-4 flex justify-between items-center text-white">
                        <span class="text-xs font-bold uppercase tracking-widest">Active Appointment</span>
                        <span class="px-2 py-1 bg-white/20 rounded text-[10px] font-bold uppercase italic">
                            Status: {{ str_replace('_', ' ', $latestActive->status) }}
                        </span>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center text-blue-600">
                                    <i class="ri-medicine-bottle-line text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-lg font-black text-slate-900 uppercase">Dr. {{ $latestActive->schedule->doctor->name ?? 'Assigned Doctor' }}</p>
                                    <p class="text-sm text-slate-500 font-medium">{{ $latestActive->schedule->doctor->specialization ?? 'General' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-3xl font-black text-blue-600">#{{ sprintf('%03d', $latestActive->queue_number) }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Your Queue</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 py-4 border-t border-slate-50">
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Date</p>
                                <p class="text-sm font-bold text-slate-800">{{ \Carbon\Carbon::parse($latestActive->appointment_date)->format('l, d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Patient Name</p>
                                <p class="text-sm font-bold text-slate-800">{{ $latestActive->name }} ({{ $latestActive->age }}y)</p>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="bg-blue-50 border-2 border-dashed border-blue-200 rounded-2xl p-10 text-center">
                    <p class="text-blue-800 font-bold mb-2 text-lg">No Upcoming Visits</p>
                    <p class="text-blue-600/70 text-sm mb-6">Need a checkup? Book your slot now.</p>
                    <a href="{{ route('doctors.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold text-sm shadow-lg shadow-blue-200">Book Appointment</a>
                </div>
                @endif

                <div class="grid grid-cols-2 md:grid-cols-2 gap-4">
                    <a href="{{ route('appointments.index') }}" class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm text-center hover:bg-slate-50">
                        <i class="ri-file-list-3-line text-blue-500 text-xl block mb-1"></i>
                        <span class="text-xs font-bold text-slate-700">My Records</span>
                    </a>
                    <a href="/profile" class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm text-center hover:bg-slate-50">
                        <i class="ri-user-settings-line text-purple-500 text-xl block mb-1"></i>
                        <span class="text-xs font-bold text-slate-700">Account</span>
                    </a>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-2xl p-6 text-white shadow-xl shadow-slate-200">
                    <h3 class="text-xs font-black uppercase text-slate-500 mb-4 tracking-widest">Health Stats</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600 text-black">Scheduled</span>
                            <span class="text-xl font-bold text-black">{{ $stats['upcoming_count'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600 text-black">Total Visits</span>
                            <span class="text-xl font-bold text-emerald-400">{{ $stats['total_history'] }}</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl p-6 border border-slate-200">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i class="ri-history-line text-blue-600"></i> Recent History
                    </h3>
                    @foreach($recentHistory as $past)
                    <div class="py-3 border-b border-slate-50 last:border-0">
                        <p class="text-xs font-black text-slate-900 uppercase">Dr. {{ $past->schedule->doctor->name ?? 'Medical Center' }}</p>
                        <p class="text-[10px] text-slate-500 font-bold">{{ \Carbon\Carbon::parse($past->appointment_date)->format('d M, Y') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection