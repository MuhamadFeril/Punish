<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\HasApiTokens;

#[Fillable(['name', 'email', 'password', 'role', 'photo'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;
    

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'google_id',
        'avatar',
        'photo',
        'otp_verified_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Default attribute values
     */
    protected $attributes = [
        'role' => 'user', // ✅ biar gak null kayak harapan 😹
    ];

    /**
     * Attribute casting
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'otp_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Optional helper (biar clean cek role)
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getInitialsAttribute(): string
    {
        $parts = preg_split('/\s+/', trim((string) $this->name)) ?: [];
        $initials = collect($parts)
            ->filter()
            ->take(2)
            ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
            ->implode('');

        return $initials !== '' ? $initials : 'U';
    }

    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (!$this->photo || !Route::has('profile.photo')) {
            return null;
        }

        $version = $this->updated_at ? $this->updated_at->timestamp : now()->timestamp;

        return route('profile.photo', ['v' => $version]);
    }
}
