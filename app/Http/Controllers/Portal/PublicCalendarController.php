<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\Department;


class PublicCalendarController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear  = $request->input('year', now()->year);
        $selectedMonth = $request->input('month', '');

        $query = Program::with([
                'department',
                'staffInCharge'
            ])
            ->whereYear('start_date', $selectedYear);

        if ($selectedMonth) {
            $query->whereMonth(
                'start_date',
                $selectedMonth
            );
        }

        $programs = $query
            ->orderBy('start_date')
            ->get();

        $departments = Department::orderBy('name')->get();

        $currentYear = now()->year;

        $yearOptions = [];

        for ($y = $currentYear; $y >= $currentYear - 4; $y--) {
            $yearOptions[] = $y;
        }

        $monthOptions = [];

        for ($m = 1; $m <= 12; $m++) {

            $monthOptions[] = [
                'value' => $m,
                'label' => date(
                    'F',
                    mktime(0,0,0,$m,1)
                )
            ];
        }

        // Calendar JSON
        $calendarEvents = [];

        foreach ($programs as $p) {

            $calendarEvents[] = [

                'id' => $p->id,

                'title' => $p->title,

                'start' => $p->start_date,

                'end' => $p->end_date,

                'department' =>
                    $p->department->name ?? '-',

                'department_id' =>
                    $p->department_id,

                'status' =>
                    strtolower($p->status),

                'venue' =>
                    $p->venue,

                'person_in_charge' =>
                    $p->staffInCharge->name ?? '-',

                'description' =>
                    $p->description,
            ];
        }

        return view(
            'Portal.public-calendar',
            compact(
                'programs',
                'departments',
                'calendarEvents',
                'yearOptions',
                'monthOptions',
                'selectedYear',
                'selectedMonth'
            )
        );
    }
}
