<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // One Department has many Staff
    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    // One Department has many Programs
    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    // Many-to-Many relationship with User through department_access pivot table
    public function accessibleUsers()
    {
        return $this->belongsToMany(
            User::class,
            'department_access'
        );
    }
}