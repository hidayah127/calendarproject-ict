<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Programstaff extends Pivot
{
    protected $table = 'program_staff';

    protected $fillable = [
        'program_id',
        'staff_id',
        'role',
        'responsibility',
        'is_lead',
    ];

    protected $casts = [
        'is_lead' => 'boolean',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
