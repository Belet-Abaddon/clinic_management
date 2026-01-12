<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { color: #2563eb; font-size: 20px; font-weight: bold; }
        .status { font-weight: bold; color: #059669; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">MedAdmin Appointment Update</div>
        <p>Dear <strong>{{ $appointment->name }}</strong>,</p>
        <p>We are writing to update you on your appointment status.</p>
        
        <ul>
            <li><strong>Queue Number:</strong> #{{ $appointment->queue_number }}</li>
            <li><strong>Status:</strong> <span class="status">{{ strtoupper($appointment->status) }}</span></li>
            <li><strong>Doctor:</strong> Dr. {{ $appointment->schedule->doctor->name }}</li>
        </ul>

        <p>Please ensure you are at the clinic on time. Thank you!</p>
    </div>
</body>
</html>