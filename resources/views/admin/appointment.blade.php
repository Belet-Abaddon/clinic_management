@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Appointment Management</h2>
            <p class="text-sm text-gray-500">Managing patient queues by numeric schedules.</p>
        </div>
        <button onclick="toggleModal('appointmentModal', true)" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition flex items-center shadow-lg shadow-blue-200">
            <i class="ri-add-line mr-2"></i> Take Appointment
        </button>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Total</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-yellow-100 shadow-sm">
            <p class="text-xs text-yellow-500 uppercase font-bold tracking-wider">Pending</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['pending'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-blue-100 shadow-sm">
            <p class="text-xs text-blue-500 uppercase font-bold tracking-wider">On Service</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['on_service'] }}</p>
        </div>
        <div class="bg-white p-4 rounded-xl border border-green-100 shadow-sm">
            <p class="text-xs text-green-500 uppercase font-bold tracking-wider">Completed</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['completed'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase font-bold">
                <tr>
                    <th class="px-6 py-4">Queue</th>
                    <th class="px-6 py-4">Patient Details</th>
                    <th class="px-6 py-4">Doctor & Time</th>
                    <th class="px-6 py-4">Status Update</th>
                    <th class="px-6 py-4 text-right">Taken By</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($appointments as $app)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <span class="bg-blue-50 text-blue-700 font-black px-3 py-1 rounded-lg border border-blue-100">
                            #{{ $app->queue_number }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800">{{ $app->name }}</div>
                        <div class="text-xs text-gray-500">{{ $app->phone }} | Age: {{ $app->age }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-800">
                            Dr. {{ $app->schedule->doctor->name }}
                            <span class="text-blue-600 text-xs">({{ $app->schedule->doctor->specialty }})</span>
                        </div>
                        <div class="text-xs text-gray-400 italic">
                            @php
                            $days = [0=>'Sun', 1=>'Mon', 2=>'Tue', 3=>'Wed', 4=>'Thu', 5=>'Fri', 6=>'Sat'];
                            @endphp
                            {{ $days[$app->schedule->date] ?? '' }}, {{ \Carbon\Carbon::parse($app->appointment_date)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.appointments.updateStatus', $app->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="text-xs font-bold uppercase rounded-full px-3 py-1 border 
                                {{ $app->status == 'pending' ? 'bg-yellow-50 text-yellow-600 border-yellow-200' : '' }}
                                {{ $app->status == 'on_service' ? 'bg-blue-50 text-blue-600 border-blue-200' : '' }}
                                {{ $app->status == 'completed' ? 'bg-green-50 text-green-600 border-green-200' : '' }}">
                                <option value="pending" {{ $app->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="on_service" {{ $app->status == 'on_service' ? 'selected' : '' }}>On Service</option>
                                <option value="completed" {{ $app->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right text-xs text-gray-400 italic">{{ $app->taken_by }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">No appointments found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div id="appointmentModal" class="fixed inset-0 bg-black/60 hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl p-8 w-full max-w-lg shadow-2xl">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800">New Appointment</h3>
            <button onclick="toggleModal('appointmentModal', false)" class="text-gray-400 hover:text-gray-600"><i class="ri-close-line ri-xl"></i></button>
        </div>

        <form action="{{ route('admin.appointments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Appointment Date</label>
                <input type="date" name="appointment_date" id="date_picker" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Select Doctor & Time</label>
                <select name="schedule_id" id="doctor_select" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500" required disabled>
                    <option value="">Choose a date first...</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Patient Name</label>
                    <input type="text" name="name" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Age</label>
                    <input type="number" name="age" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input type="email" name="email" class="w-full mt-1 border-gray-300 rounded-lg shadow-sm" required placeholder="patient@example.com">
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold hover:bg-blue-700 transition mt-4">
                Confirm & Create
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleModal(id, show) {
        document.getElementById(id).classList.toggle('hidden', !show);
    }

    document.getElementById('date_picker').addEventListener('change', function() {
        const dateObj = new Date(this.value);
        const dayInt = dateObj.getDay(); // 0=Sun, 1=Mon, etc. - MATCHES YOUR DATABASE

        const doctorSelect = document.getElementById('doctor_select');
        doctorSelect.innerHTML = '<option>Checking schedules...</option>';
        doctorSelect.disabled = true;

        // URL matches your Route Group: /admin/appointments/get-schedules
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
                doctorSelect.innerHTML = '<option value="">Error loading schedules</option>';
            });
    });
</script>
@endsection