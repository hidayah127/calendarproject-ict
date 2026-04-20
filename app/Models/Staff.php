<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Staff extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'staff';

    protected $fillable = [
        'staff_id',
        'name',
        'email',
        'phone',
        'position',
        'department_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Staff belongs to a Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Staff has one User account
    public function user()
    {
        return $this->hasOne(User::class);
    }

    // Staff can be in charge of many programs
    public function programsInCharge()
    {
        return $this->hasMany(Program::class, 'staff_in_charge_id');
    }
}