<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Admin;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'venue',
        'start_date',
        'end_date',
        'status',
        'category',
        'created_by',
        'department_id',
        'staff_in_charge_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Program belongs to Department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Program belongs to User (Creator / HD)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Program belongs to Staff (Person in Charge)
    public function staffInCharge()
    {
        return $this->belongsTo(Staff::class, 'staff_in_charge_id');
    }

    // Committee members via pivot
    public function committee()
    {
        return $this->belongsToMany(Staff::class, 'program_staff')
            ->using(Programstaff::class)
            ->withPivot(['role', 'responsibility', 'is_lead'])
            ->withTimestamps();
    }

    // ── Auto-compute status ────────────────────────
    public function getStatusAttribute($value): string
    {
        // Never override cancelled — it's a manual decision
        if ($value === 'cancelled') {
            return 'cancelled';
        }
 
        $now = Carbon::now();

        if ($this->end_date && $now->gt($this->end_date)) {
            return 'completed';
        }

        if ($this->start_date && $now->gte($this->start_date) && $this->end_date && $now->lte($this->end_date)) {
            return 'ongoing';
        }

        return $value; // upcoming or rescheduled
    }

    public function scopeWithStatus($query, string $status)
    {
        $now = now();

        return match ($status) {
            'cancelled' => $query->where('status', 'cancelled'),

            'completed' => $query->where('status', '!=', 'cancelled')
                                ->where('end_date', '<', $now),

            'ongoing'   => $query->where('status', '!=', 'cancelled')
                                ->where('start_date', '<=', $now)
                                ->where('end_date', '>=', $now),

            // not cancelled, not started yet, and the stored value is upcoming/rescheduled
            'upcoming',
            'rescheduled' => $query->where('status', $status)
                                ->where('start_date', '>', $now),

            default     => $query,
        };
    }

    
}