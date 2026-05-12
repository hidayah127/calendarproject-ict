<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeritClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'program_id',
        'claim_type',
        'merit_points',
        'proof_path',
        'proof_original_name',
        'status',
        'rejection_reason',
        'reviewed_at',
        'reviewed_by',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Merit points per claim type
    |--------------------------------------------------------------------------
    */
    public static array $meritPoints = [
        'attendee'         => 5,
        'committee_member' => 10,
        // 'facilitator'      => 4,
        // 'secretary'        => 4,
        // 'treasurer'        => 4,
        // 'coordinator'      => 5,        
        // 'committee_head'   => 6,
    ];

    public static array $claimLabels = [
        'attendee'         => 'Program Attendee',
        'committee_member' => 'Committee Member',
        // 'facilitator'      => 'Facilitator',
        // 'secretary'        => 'Secretary',
        // 'treasurer'        => 'Treasurer',
        // 'coordinator'      => 'Coordinator',
        // 'committee_head'   => 'Committee Head',
    ];

    public static array $claimIcons = [
        'attendee'         => 'fa-user-check',
        'committee_member' => 'fa-users',
        // 'facilitator'      => 'fa-chalkboard-user',
        // 'secretary'        => 'fa-pen-clip',
        // 'treasurer'        => 'fa-coins',
        // 'coordinator'      => 'fa-star',
        // 'committee_head'   => 'fa-crown',
    ];      

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function staff()
    {
        return $this->belongsTo(Staff::class);      
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'approved' => '#15803d',
            'rejected' => '#b91c1c',
            default    => '#b45309',
        };
    }

    public function getStatusBgAttribute(): string
    {
        return match($this->status) {
            'approved' => '#dcfce7',
            'rejected' => '#fee2e2',
            default    => '#fef9c3',
        };
    }

    public function files()
    {
        return $this->hasMany(MeritClaimFile::class);
    }

}
