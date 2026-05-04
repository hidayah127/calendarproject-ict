<?php

namespace App\Http\Controllers\HOD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // CHECK STAFF + DEPARTMENT
        if (!$user->staff || !$user->staff->department_id) {
            abort(403, 'Your account is not assigned to any department.');
        }

        $departmentId = $user->staff->department_id;

        // FILTERS
        $selectedYear  = $request->input('year', now()->year);
        $selectedMonth = $request->input('month');

        // QUERY
        $query = Program::with(['department', 'committee'])
            ->where('department_id', $departmentId)
            ->whereYear('start_date', $selectedYear);

        if ($selectedMonth) {
            $query->whereMonth('start_date', $selectedMonth);
        }

        $programs = $query
            ->orderBy('start_date', 'desc')
            ->get();

        // GROUP BY WEEK (done here, not in Blade)
        $grouped = $programs->groupBy(function ($p) {
            $monday = $p->start_date->copy()->startOfWeek();
            $sunday = $p->start_date->copy()->endOfWeek();
            return $monday->format('d M') . ' – ' . $sunday->format('d M Y');
        });

        // YEAR OPTIONS
        $currentYear = now()->year;
        $yearOptions = [];
        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {
            $yearOptions[] = $y;
        }

        // MONTH OPTIONS
        $monthOptions = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthOptions[] = [
                'value' => $m,
                'label' => date('F', mktime(0, 0, 0, $m, 1)),
            ];
        }

        return view('HOD.Program', [
            'programs'       => $programs,
            'grouped'        => $grouped,
            'selectedYear'   => $selectedYear,
            'selectedMonth'  => $selectedMonth,
            'yearOptions'    => $yearOptions,
            'monthOptions'   => $monthOptions,
            'departmentName' => $user->staff->department->name ?? '—',
        ]);
    }
}
