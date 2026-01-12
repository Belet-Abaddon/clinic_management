<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    // This makes the $appointment data available to the email
    public function __construct(public Appointment $appointment) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Appointment Update - MedAdmin',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-notification', // This is the file we will make next
        );
    }
}