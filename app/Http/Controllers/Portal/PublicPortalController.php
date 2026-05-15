<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeritClaim;
use App\Models\Program;
use App\Models\Staff;
use Illuminate\Support\Facades\Storage;


class PublicPortalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Landing — staff ID lookup form
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        return view('Portal.index');
    }
 
    /*
    |--------------------------------------------------------------------------
    | Lookup — find staff by staff_id and show their dashboard
    |--------------------------------------------------------------------------
    */
    public function lookup(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|string|max:50',
        ]);

        $staff = Staff::with(['department'])
            ->where('staff_id', $request->staff_id)
            ->first();

        if (!$staff) {
            return back()
                ->withErrors(['staff_id' => 'Staff ID not found. Please check and try again.'])
                ->withInput();
        }

        // ✅ Store staff ID in session and redirect to a GET route
        return redirect()->route('Portal.dashboard', ['staff' => $staff->staff_id]);
    }

    //  Dashboard — shows staff info, claims, and programs
    public function dashboard(Request $request)
    {
        $staff = Staff::with(['department'])
            ->where('staff_id', $request->staff)
            ->firstOrFail();

        $programs = Program::with(['department'])
            ->whereNotIn('status', ['cancelled'])
            ->whereHas('department', function ($query) {
                $query->where('name', 'Be An Amazing You');
            })
            ->orderBy('start_date', 'desc')
            ->get();

        $claims = MeritClaim::with('program', 'files')
            ->where('staff_id', $staff->id)
            ->orderByDesc('created_at')
            ->get();

        $totalMerits = $claims->where('status', 'approved')->sum('merit_points');

        $claimedKeys = $claims->mapWithKeys(fn($c) => [
            $c->program_id . '_' . $c->claim_type => true
        ]);

    //    $categorySummary = $claims
    //     ->where('status', 'approved')
    //     ->groupBy(function ($claim) {
    //         return $claim->program->category ?? 'Others';
    //     })
    //     ->map(function ($catClaims) {
    //         return $catClaims->sum('merit_points');
    //     });

       // Define all categories (always show these)
        $allCategories = [
            'social',
            'mind',
            'fitness',
            'spiritual'
        ];

        // Get approved claims grouped by category
        $approvedClaims = $claims
            ->where('status', 'approved')
            ->groupBy(function ($claim) {
                return $claim->program->category ?? 'Others';
            });

        // Build summary with default 0
        $categorySummary = collect();

        foreach ($allCategories as $category) {

            $points = isset($approvedClaims[$category])
                ? $approvedClaims[$category]->sum('merit_points')
                : 0;

            $categorySummary[$category] = $points;
        }

        $categoryBreakdown = $claims
        ->where('status', 'approved')
        ->groupBy(function ($claim) {
            return $claim->program->category ?? 'Others';
        });

        return view('Portal.dashboard', compact(
            'staff',
            'programs',
            'claims',
            'totalMerits',
            'claimedKeys',
            'categorySummary',
            'categoryBreakdown'
        ));
    }

     /*
    |--------------------------------------------------------------------------
    | Submit claim — check-in or committee role
    |--------------------------------------------------------------------------
    */
    public function claim(Request $request)
    {
        $request->validate([
            'staff_id'   => 'required|exists:staff,id',
            'program_id' => 'required|exists:programs,id',
            'claim_type' => 'required|in:attendee,committee_member,committee_head,coordinator,secretary,treasurer,facilitator',
            // 'proof'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'proof' => 'required|array',
            'proof.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $exists = MeritClaim::where('staff_id',  $request->staff_id)
            ->where('program_id', $request->program_id)
            ->where('claim_type', $request->claim_type)
            ->exists();

        if ($exists) {
            return $this->backToDashboard($request->staff_id, 'error', 'You have already submitted this claim.');
        }

        // $proofPath = $proofOriginalName = null;

        // if ($request->hasFile('proof')) {
        //     $file              = $request->file('proof');
        //     $proofOriginalName = $file->getClientOriginalName();
        //     $proofPath         = $file->store('merit-proofs', 'public');
        // }

        $uploadedFiles = [];

        if($request->hasFile('proof')){

            foreach($request->file('proof') as $file){

                $path = $file->store('merit-proofs', 'public');

                $uploadedFiles[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                ];

            }

        }

        // MeritClaim::create([
        //     'staff_id'            => $request->staff_id,
        //     'program_id'          => $request->program_id,
        //     'claim_type'          => $request->claim_type,
        //     'merit_points'        => MeritClaim::$meritPoints[$request->claim_type] ?? 1,
        //     // 'proof_path'          => $proofPath,
        //     // 'proof_original_name' => $proofOriginalName,
        //     'proof_path' => json_encode($uploadedFiles),
        //     'status'              => 'pending',
        // ]);

        $claim = MeritClaim::create([
            'staff_id'     => $request->staff_id,
            'program_id'   => $request->program_id,
            'claim_type'   => $request->claim_type,
            'merit_points' => MeritClaim::$meritPoints[$request->claim_type] ?? 1,
            'status'       => 'pending',
        ]);

        if($request->hasFile('proof')){

            foreach($request->file('proof') as $file){

                $path = $file->store('merit-proofs', 'public');

                $claim->files()->create([
                    'file_path'     => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);

            }

        }

        $staffIdCode = Staff::find($request->staff_id)->staff_id;
        return $this->backToDashboard($staffIdCode, 'success', 'Your claim has been submitted and is pending review.');
    }

     /*
    |--------------------------------------------------------------------------
    | Upload proof for existing claim
    |--------------------------------------------------------------------------
    */
    public function uploadProof(Request $request, MeritClaim $claim)
    {
        $request->validate([
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($claim->proof_path) {
            Storage::disk('public')->delete($claim->proof_path);
        }

        $file = $request->file('proof');

        $claim->update([
            'proof_path'          => $file->store('merit-proofs', 'public'),
            'proof_original_name' => $file->getClientOriginalName(),
            'status'              => 'pending',
        ]);

        $staffIdCode = $claim->staff->staff_id;
        return $this->backToDashboard($staffIdCode, 'success', 'Proof uploaded successfully. Your claim is now under review.');
    }

    // ── Helper ──
    private function backToDashboard(string $staffId, string $type, string $message)
    {
        return redirect()
            ->route('Portal.dashboard', ['staff' => $staffId])
            ->with($type, $message);
    }
}
