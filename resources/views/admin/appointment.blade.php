@extends('layouts.admin')

@section('title', 'Appointment Management')

@section('content')
<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 tracking-tight uppercase">Appointment Management</h2>
            <p class="text-sm text-gray-500 font-medium">Managing patient queues by numeric schedules.</p>
        </div>
        <button onclick="toggleModal('appointmentModal', true)" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-100 font-bold text-sm">
            <i class="ri-add-line mr-2 text-lg"></i> Take Appointment
        </button>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Doctor</label>
                <select name="doctor_id" class="w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                    <option value="">All Doctors</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        Dr. {{ $doctor->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Specific Schedule</label>
                <select name="schedule_id" class="w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                    <option value="">All Time Slots</option>
                    @foreach($schedules as $sch)
                    @php $days = [0=>'Sun', 1=>'Mon', 2=>'Tue', 3=>'Wed', 4=>'Thu', 5=>'Fri', 6=>'Sat']; @endphp
                    <option value="{{ $sch->id }}" {{ request('schedule_id') == $sch->id ? 'selected' : '' }}>
                        {{ $days[$sch->date] ?? '' }}: Dr. {{ $sch->doctor->name }} ({{ substr($sch->start_time, 0, 5) }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Status</label>
                <select name="status" class="w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 p-3">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="on_service" {{ request('status') == 'on_service' ? 'selected' : '' }}>On Service</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-gray-900 text-white py-2.5 rounded-xl hover:bg-black transition text-xs font-black uppercase tracking-widest">
                    Filter
                </button>
                <a href="{{ route('admin.appointments.index') }}" class="flex-1 bg-gray-100 text-gray-600 py-2.5 rounded-xl hover:bg-gray-200 transition text-xs font-black uppercase tracking-widest text-center">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest">Total Appointments</p>
            <p class="text-2xl font-black text-gray-800 mt-1">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border-l-4 border-l-yellow-400 shadow-sm border border-gray-100">
            <p class="text-[10px] text-yellow-500 uppercase font-black tracking-widest">Pending Queue</p>
            <p class="text-2xl font-black text-gray-800 mt-1">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border-l-4 border-l-blue-500 shadow-sm border border-gray-100">
            <p class="text-[10px] text-blue-500 uppercase font-black tracking-widest">On Service</p>
            <p class="text-2xl font-black text-gray-800 mt-1">{{ $stats['on_service'] }}</p>
        </div>
        <div class="bg-white p-5 rounded-2xl border-l-4 border-l-green-500 shadow-sm border border-gray-100">
            <p class="text-[10px] text-green-500 uppercase font-black tracking-widest">Completed</p>
            <p class="text-2xl font-black text-gray-800 mt-1">{{ $stats['completed'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-400 text-[10px] uppercase font-black tracking-widest">
                <tr>
                    <th class="px-6 py-4">Queue</th>
                    <th class="px-6 py-4">Patient Details</th>
                    <th class="px-6 py-4">Doctor & Schedule</th>
                    <th class="px-6 py-4">Status Update</th>
                    <th class="px-6 py-4 text-right">Handled By</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($appointments as $app)
                <tr class="hover:bg-gray-50/50 transition">
                    <td class="px-6 py-4">
                        <span class="bg-blue-50 text-blue-700 font-black px-3 py-1.5 rounded-xl border border-blue-100 text-sm">
                            #{{ str_pad($app->queue_number, 3, '0', STR_PAD_LEFT) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800">{{ $app->name }}</div>
                        <div class="text-[11px] text-gray-500 font-medium">{{ $app->phone }} | Age: {{ $app->age }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800 flex items-center">
                            <i class="ri-user-star-line mr-1.5 text-blue-600"></i>
                            Dr. {{ $app->schedule->doctor->name }}
                        </div>
                        <div class="text-[11px] text-gray-400 mt-0.5 font-medium">
                            @php $days = [0=>'Sun', 1=>'Mon', 2=>'Tue', 3=>'Wed', 4=>'Thu', 5=>'Fri', 6=>'Sat']; @endphp
                            {{ $days[$app->schedule->date] ?? '' }}, {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.appointments.updateStatus', $app->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-[10px] font-black uppercase rounded-full px-4 py-1.5 border appearance-none cursor-pointer transition-all
                                {{ $app->status == 'pending' ? 'bg-yellow-50 text-yellow-600 border-yellow-200' : '' }}
                                {{ $app->status == 'on_service' ? 'bg-blue-50 text-blue-600 border-blue-200' : '' }}
                                {{ $app->status == 'completed' ? 'bg-green-50 text-green-600 border-green-200' : '' }}">
                                <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="on_service" {{ $app->status == 'on_service' ? 'selected' : '' }}>On Service</option>
                                <option value="completed" {{ $app->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter italic">{{ $app->taken_by }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.appointments.notify', $app->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg border border-blue-100 hover:bg-blue-600 hover:text-white transition-all text-[10px] font-bold uppercase">
                                <i class="ri-mail-send-line"></i> Notify
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <i class="ri-calendar-event-line text-4xl text-gray-200 block mb-2"></i>
                        <p class="text-gray-400 font-medium">No appointments match your filter.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="appointmentModal" class="fixed inset-0 bg-gray-900/60 hidden backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-3xl p-8 w-full max-w-lg shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800 flex items-center tracking-tight">
                <i class="ri-add-circle-fill text-blue-600 mr-2 text-2xl"></i> New Appointment
            </h3>
            <button onclick="toggleModal('appointmentModal', false)" class="p-2 bg-gray-50 rounded-xl text-gray-400 hover:text-red-500 transition">
                <i class="ri-close-line text-xl"></i>
            </button>
        </div>

        <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Appointment Date</label>
                <input type="date" name="appointment_date" id="date_picker" class="w-full rounded-xl border-gray-200 p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" required>
            </div>

            <div>
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Select Doctor & Time</label>
                <select name="schedule_id" id="doctor_select" class="w-full rounded-xl border-gray-200 p-3 focus:ring-blue-500 focus:border-blue-500 shadow-sm" required disabled>
                    <option value="">Select a date first...</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Patient Full Name</label>
                    <input type="text" name="name" class="w-full rounded-xl border-gray-200 p-3 shadow-sm" required placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Age</label>
                    <input type="number" name="age" class="w-full rounded-xl border-gray-200 p-3 shadow-sm" required>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Phone</label>
                    <input type="text" name="phone" class="w-full rounded-xl border-gray-200 p-3 shadow-sm" required placeholder="+12345678">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Email Address</label>
                    <input type="email" name="email" class="w-full rounded-xl border-gray-200 p-3 shadow-sm" required placeholder="patient@clinic.com">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition mt-4 shadow-xl shadow-blue-100">
                Confirm & Record Entry
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleModal(id, show) {
        const modal = document.getElementById(id);
        if (show) {
            modal.classList.remove('hidden');
        } else {
            modal.classList.add('hidden');
        }
    }

    document.getElementById('date_picker').addEventListener('change', function() {
        const dateObj = new Date(this.value);
        const dayInt = dateObj.getDay();

        const doctorSelect = document.getElementById('doctor_select');
        doctorSelect.innerHTML = '<option>Checking clinic schedule...</option>';
        doctorSelect.disabled = true;

        fetch(`/admin/appointments/get-schedules?day=${dayInt}`)
            .then(res => res.json())
            .then(data => {
                doctorSelect.innerHTML = '';
                if (data.length === 0) {
                    doctorSelect.innerHTML = '<option value="">No doctors available on this day</option>';
                } else {
                    doctorSelect.disabled = false;
                    doctorSelect.innerHTML = '<option value="">-- Choose Doctor --</option>';
                    data.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.id;
                        const specialty = item.doctor.specialty ? `[${item.doctor.specialty}]` : '';
                        const timeRange = `${item.start_time.substring(0, 5)} - ${item.end_time.substring(0, 5)}`;
                        opt.textContent = `Dr. ${item.doctor.name} ${specialty} (${timeRange})`;
                        doctorSelect.appendChild(opt);
                    });
                }
            })
            .catch(err => {
                doctorSelect.innerHTML = '<option value="">Error connecting to server</option>';
            });
    });
</script>
@endsection