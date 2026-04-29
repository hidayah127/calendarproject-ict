<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'staff_id',
        'reset_token',
        'reset_token_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // User belongs to Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    // User (HD) can create many Programs
    public function programs()
    {
        return $this->hasMany(Program::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Role Helper Methods
    |--------------------------------------------------------------------------
    */

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isVC()
    {
        return $this->role === 'vc';
    }

    public function isHD()
    {
        return $this->role === 'hd';
    }

    public function isLD()
    {
        return $this->role === 'ld';
    }
}