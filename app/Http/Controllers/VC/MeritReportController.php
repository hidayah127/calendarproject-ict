<?php

namespace App\Http\Controllers\VC;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MeritClaim;
use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Http\Request;
class MeritReportController extends Controller
{

    //function to get staff merits data for both index and export
    private function getStaffMerits()
    {
        $approvedClaims = MeritClaim::with(['staff', 'staff.department', 'program'])
            ->where('status', 'approved')
            ->get();
        $staffMerits = [];  
        foreach ($approvedClaims as $claim) {
            $sid = $claim->staff_id;
            if (!isset($staffMerits[$sid])) {
                $staffMerits[$sid] = [
                    'id'          => $claim->staff->id,
                    'name'        => $claim->staff->name,
                    'staff_id'    => $claim->staff->staff_id,
                    'position'    => $claim->staff->position ?? '—',
                    'department'  => $claim->staff->department->name ?? '—',
                    'dept_id'     => $claim->staff->department_id,
                    'total_merits'=> 0,
                    'total_claims'=> 0,
                ];
            }
            $staffMerits[$sid]['total_merits'] += $claim->merit_points;
            $staffMerits[$sid]['total_claims'] += 1;

            // group by role (optional, can be removed if not needed for export)
            $role = $claim->claim_type;
            if (!isset($staffMerits[$sid]['by_role'][$role])) {
                $staffMerits[$sid]['by_role'][$role] = ['count' => 0, 'pts' => 0];
            }
            $staffMerits[$sid]['by_role'][$role]['count'] += 1;
            $staffMerits[$sid]['by_role'][$role]['pts']   += $claim
                ->merit_points;

                // programs list (optional, can be removed if not needed for export)
            $staffMerits[$sid]['programs'][] = [
                'title'      => $claim->program->title ?? '—',
                'claim_type' => $claim->claim_type,
                'pts'        => $claim->merit_points,
            ];      

        }

        // Sort by total highest merits
        usort($staffMerits, fn($a, $b) => $b['total_merits'] - $a['total_merits']);
        return $staffMerits;
    }

    public function index(Request $request)
    {
        $selectedYear = $request->input('year', now()->year);

        $departments = Department::orderBy('name')->get();

        $currentYear = now()->year;

        $yearOptions = [];

        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {
            $yearOptions[] = $y;
        }

        // All approved claims grouped by staff
        $approvedClaims = MeritClaim::with(['staff', 'staff.department', 'program'])
            ->where('status', 'approved')
            ->whereYear('created_at', $selectedYear)
            ->get();

        // Build staff merit data
        $staffMerits = [];

        foreach ($approvedClaims as $claim) {
            $sid = $claim->staff_id;

            if (!isset($staffMerits[$sid])) {
                $staffMerits[$sid] = [
                    'id'          => $claim->staff->id,
                    'name'        => $claim->staff->name,
                    'staff_id'    => $claim->staff->staff_id,
                    'position'    => $claim->staff->position ?? '—',
                    'department'  => $claim->staff->department->name ?? '—',
                    'dept_id'     => $claim->staff->department_id,
                    'total_merits'=> 0,
                    'total_claims'=> 0,
                    'by_role'     => [],
                    'programs'    => [],
                ];
            }

            $staffMerits[$sid]['total_merits'] += $claim->merit_points;
            $staffMerits[$sid]['total_claims'] += 1;

            // Group by role
            $role = $claim->claim_type;
            if (!isset($staffMerits[$sid]['by_role'][$role])) {
                $staffMerits[$sid]['by_role'][$role] = ['count' => 0, 'pts' => 0];
            }
            $staffMerits[$sid]['by_role'][$role]['count'] += 1;
            $staffMerits[$sid]['by_role'][$role]['pts']   += $claim->merit_points;

            // Programs list
            $staffMerits[$sid]['programs'][] = [
                'title'      => $claim->program->title ?? '—',
                'claim_type' => $claim->claim_type,
                'pts'        => $claim->merit_points,
            ];
        }

        // Sort by total merits descending
        usort($staffMerits, fn($a, $b) => $b['total_merits'] - $a['total_merits']);

        // Summary stats
        $totalStaffWithMerit = count($staffMerits);
        $totalMeritsAwarded  = array_sum(array_column($staffMerits, 'total_merits'));
        $totalClaimsApproved = array_sum(array_column($staffMerits, 'total_claims'));
        $topStaff            = $staffMerits[0] ?? null;
        $maxMerits           = $topStaff ? $topStaff['total_merits'] : 1;

        // Merit points reference
        $meritPoints = MeritClaim::$meritPoints;
        $roleLabels  = MeritClaim::$claimLabels;
        $roleIcons   = MeritClaim::$claimIcons;

        return view('vc.merit-report', compact(
            'staffMerits',
            'departments',
            'totalStaffWithMerit',
            'totalMeritsAwarded',
            'totalClaimsApproved',
            'topStaff',
            'maxMerits',
            'meritPoints',
            'roleLabels',
            'roleIcons',
            'yearOptions',
            'selectedYear'
        ));
    }

    public function exportCSV()
    {
        $staffMerits = $this->getStaffMerits(); 
        // use your existing data method

        $filename = "staff_merit_leaderboard.csv";

        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function() use ($staffMerits) {

            $file = fopen('php://output', 'w');

            // Column headings
            fputcsv($file, [
                'Rank',
                'Staff Name',
                'Staff ID',
                'Department',
                'Position',
                'Total Claims',
                'Total Merits'
            ]);

            foreach ($staffMerits as $index => $staff) {

                fputcsv($file, [
                    $index + 1,
                    $staff['name'],
                    $staff['staff_id'],
                    $staff['department'],
                    $staff['position'],
                    $staff['total_claims'],
                    $staff['total_merits'],
                ]);

            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
