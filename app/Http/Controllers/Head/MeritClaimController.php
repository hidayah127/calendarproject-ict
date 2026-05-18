<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use App\Models\MeritClaim;
use App\Models\MeritClaimFile;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeritClaimController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Index — list all claims for HD's programs
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        // Get all programs created by this HD
        $programIds = Program::where('created_by', Auth::id())->pluck('id');

        $claims = MeritClaim::with(['staff', 'staff.department', 'program', 'files'])
            ->whereIn('program_id', $programIds)
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->program_id, fn($q, $p) => $q->where('program_id', $p))
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderByDesc('created_at')
            ->get();

        $programs = Program::where('created_by', Auth::id())
            ->orderBy('title')
            ->get();

        $pendingCount  = $claims->where('status', 'pending')->count();
        $approvedCount = $claims->where('status', 'approved')->count();
        $rejectedCount = $claims->where('status', 'rejected')->count();

        return view('Head.merit-claims', compact(
            'claims',
            'programs',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
        ));
    }
 
    /*
    |--------------------------------------------------------------------------
    | Approve a claim
    |--------------------------------------------------------------------------
    */
    public function approve(MeritClaim $claim)
    {
        $this->authorise($claim);

        $claim->update([
            'status'      => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => Auth::id(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', "Claim approved — {$claim->merit_points} merit points awarded to {$claim->staff->name}.");
    }

    /*
    |--------------------------------------------------------------------------
    | Reject a claim
    |--------------------------------------------------------------------------
    */
    public function reject(Request $request, MeritClaim $claim)
    {
        $this->authorise($claim);

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $claim->update([
            'status'           => 'rejected',
            'reviewed_at'      => now(),
            'reviewed_by'      => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', "Claim rejected for {$claim->staff->name}.");
    }

    /*
    |--------------------------------------------------------------------------
    | Ensure HD owns the program this claim belongs to
    |--------------------------------------------------------------------------
    */
    private function authorise(MeritClaim $claim): void
    {
        $owned = Program::where('id', $claim->program_id)
            ->where('created_by', Auth::id())
            ->exists();

        if (!$owned) {
            abort(403, 'You are not authorised to review this claim.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Bulk Approve Selected Claims
    |--------------------------------------------------------------------------
    */
    public function bulkApprove(Request $request)
    {
        $ids = $request->claim_ids;

        if (!$ids) {
            return back()->with('error', 'No claims selected.');
        }

        // Approve only pending claims
        MeritClaim::whereIn('id', $ids)
            ->where('status', 'pending')
            ->update([
                'status'      => 'approved',
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
                'rejection_reason' => null,
            ]);

        return back()->with('success', 'Selected claims approved successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | Bulk Reject Selected Claims
    |--------------------------------------------------------------------------
    */
    // public function bulkReject(Request $request)
    // {
    //     $ids = $request->claim_ids;

    //     if (!$ids) {
    //         return back()->with('error', 'No claims selected.');
    //     }

    //     MeritClaim::whereIn('id', $ids)
    //         ->where('status', 'pending')
    //         ->update([
    //             'status'      => 'rejected',
    //             'reviewed_at' => now(),
    //             'reviewed_by' => Auth::id(),
    //             'rejection_reason' => 'Rejected in bulk review.',
    //         ]);

    //     return back()->with('success', 'Selected claims rejected successfully.');
    // }

    public function bulkReject(Request $request)
    {
        $ids = $request->claim_ids;

        $reason =
            $request->rejection_reason
            ?? 'Rejected in bulk review.';

        MeritClaim::whereIn('id', $ids)
            ->where('status', 'pending')
            ->update([
                'status'      => 'rejected',
                'reviewed_at' => now(),
                'reviewed_by' => Auth::id(),
                'rejection_reason' => $reason,
            ]);

        return back()
            ->with('success',
                'Selected claims rejected successfully.'
            );
    }

}
