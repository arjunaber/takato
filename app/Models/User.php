<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <<< FOKUS PADA KOLOM 'role' STRING
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ===================================
    // PERBAIKAN DAN PENAMBAHAN HELPER ROLE
    // ===================================

    public function isOwner()
    {
        return $this->role === 'owner'; // TRUE jika Owner
    }

    public function isAdmin()
    {
        // Admin (Supervisor/Manajer)
        return $this->role === 'admin'; // TRUE jika Admin
    }

    public function isCustomer()
    {
        // Customer (Pengguna umum/tanpa akses admin)
        return $this->role === 'customer'; // TRUE jika Customer
    }

    /**
     * Cek apakah user memiliki hak masuk ke panel admin (/admin/*).
     * Owner dan Admin (Supervisor/Kasir) diizinkan, Customer tidak.
     */
    public function canAccessAdminPanel(): bool
    {
        return $this->isOwner() || $this->isAdmin();
    }
}
