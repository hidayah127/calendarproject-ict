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
}