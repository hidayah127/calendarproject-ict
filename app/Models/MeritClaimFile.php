<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeritClaimFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'merit_claim_id',
        'file_path',
        'original_name',
    ];

    public function claim()
    {
        return $this->belongsTo(MeritClaim::class, 'merit_claim_id');
    }
}
