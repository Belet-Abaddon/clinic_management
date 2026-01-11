<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Schedule extends Model
{
    protected $fillable = ['doctor_id', 'date', 'start_time', 'end_time', 'max_queue'];

    // Convert numeric day (0-6) to String Name
    public function getDayFullNameAttribute()
    {
        $days = [
            '0' => 'Sunday',
            '1' => 'Monday',
            '2' => 'Tuesday',
            '3' => 'Wednesday',
            '4' => 'Thursday',
            '5' => 'Friday',
            '6' => 'Saturday'
        ];
        return $days[$this->date] ?? $this->date;
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function getStartTime12hAttribute()
    {
        return Carbon::parse($this->start_time)->format('h:i A');
    }

    public function getEndTime12hAttribute()
    {
        return Carbon::parse($this->end_time)->format('h:i A');
    }
}
