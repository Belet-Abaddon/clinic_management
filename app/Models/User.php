<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'date_of_birth',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
        ];
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 1;
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 0;
    }

    /**
     * Get role name
     */
    public function getRoleNameAttribute(): string
    {
        return $this->role === 1 ? 'Admin' : 'User';
    }

    /**
     * Get role badge class
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return $this->role === 1 
            ? 'bg-purple-100 text-purple-800' 
            : 'bg-blue-100 text-blue-800';
    }

    /**
     * Get role icon
     */
    public function getRoleIconAttribute(): string
    {
        return $this->role === 1 ? 'ri-shield-star-line' : 'ri-user-line';
    }

    /**
     * Format date of birth
     */
    public function getFormattedDobAttribute(): ?string
    {
        return $this->date_of_birth 
            ? \Carbon\Carbon::parse($this->date_of_birth)->format('F d, Y')
            : 'Not set';
    }

    /**
     * Format created at date
     */
    public function getFormattedCreatedAtAttribute(): string
    {
        return $this->created_at->format('M d, Y');
    }

}
