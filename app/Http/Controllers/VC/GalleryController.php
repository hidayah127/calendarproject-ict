<?php

namespace App\Http\Controllers\VC;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MeritClaim;
use App\Models\Program;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    /**
     * Human-readable labels for claim_type, matching the committee role labels
     * used elsewhere (Programs page) plus the base "attendee" type.
     */
    protected array $claimTypeLabels = [
        'attendee'         => 'Attendee',
        'committee_member' => 'Committee Member',
        'committee_head'   => 'Committee Head',
        'coordinator'      => 'Coordinator',
        'secretary'        => 'Secretary',
        'treasurer'        => 'Treasurer',
        'facilitator'      => 'Facilitator',
    ];

    protected array $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];

    public function index(Request $request)
    {
        $selectedProgram = $request->input('program', '');
        $selectedType    = $request->input('type', '');
        $selectedStatus  = $request->input('status', '');

        $query = MeritClaim::with(['staff', 'program', 'files'])
            ->orderBy('created_at', 'desc');

        if ($selectedProgram) {
            $query->where('program_id', $selectedProgram);
        }
        if ($selectedType) {
            $query->where('claim_type', $selectedType);
        }
        if ($selectedStatus) {
            $query->where('status', $selectedStatus);
        }

        $claims = $query->get();

        // Flatten every claim's proof (main proof_path + any merit_claim_files rows)
        // into individual gallery tiles, each carrying its parent claim's metadata.
        $tiles = collect();

        foreach ($claims as $claim) {
            $entries = collect();

            if ($claim->proof_path) {
                $entries->push([
                    'path' => $claim->proof_path,
                    'name' => $claim->proof_original_name ?? basename($claim->proof_path),
                ]);
            }

            foreach ($claim->files as $file) {
                $entries->push([
                    'path' => $file->file_path,
                    'name' => $file->original_name,
                ]);
            }

            foreach ($entries as $i => $entry) {
                $ext = strtolower(pathinfo($entry['path'], PATHINFO_EXTENSION));

                $tiles->push([
                    'tile_id'           => $claim->id . '-' . $i,
                    'claim_id'          => $claim->id,
                    'staff_name'        => $claim->staff->name ?? 'Unknown Staff',
                    'staff_position'    => $claim->staff->position ?? ($claim->staff->staff_id ?? ''),
                    'program_id'        => $claim->program_id,
                    'program_title'     => $claim->program->title ?? '—',
                    'claim_type'        => $claim->claim_type,
                    'claim_type_label'  => $this->claimTypeLabels[$claim->claim_type] ?? ucfirst($claim->claim_type),
                    'status'            => $claim->status,
                    'merit_points'      => $claim->merit_points,
                    'file_url'          => Storage::url($entry['path']),
                    'file_name'         => $entry['name'],
                    'is_image'          => in_array($ext, $this->imageExtensions),
                    'ext'               => $ext,
                    'uploaded_at'       => optional($claim->created_at)->format('d M Y, h:i A'),
                    'rejection_reason'  => $claim->rejection_reason,
                ]);
            }
        }

        $counts = [
            'total'    => $tiles->count(),
            'pending'  => $tiles->where('status', 'pending')->count(),
            'approved' => $tiles->where('status', 'approved')->count(),
            'rejected' => $tiles->where('status', 'rejected')->count(),
        ];

        $programs = Program::orderBy('title')->get();

        return view('VC.gallery', [
            'tiles'            => $tiles,
            'programs'         => $programs,
            'counts'           => $counts,
            'selectedProgram'  => $selectedProgram,
            'selectedType'     => $selectedType,
            'selectedStatus'   => $selectedStatus,
            'claimTypeLabels'  => $this->claimTypeLabels,
        ]);
    }
}
