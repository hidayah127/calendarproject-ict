<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Program;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStaff       = Staff::count();
        $totalDepartments = Department::count();
        $totalUsers       = User::count();
        $totalPrograms    = Program::count();
        $activePrograms   = Program::whereIn('status', ['upcoming', 'ongoing'])->count();

        $departments = Department::withCount('staff')
            ->orderBy('name')
            ->get();

        // Recent activity — last 6 notifications or staff/program events
        // Adjust this to your Notification model if you have one
        $recentActivity = \App\Models\Notification::latest()
            ->take(6)
            ->get()
            ->map(fn($n) => [
                'message'    => $n->message,
                'time'       => $n->created_at->diffForHumans(),
                'icon'       => $n->icon       ?? 'fa-bell',
                'icon_bg'    => $n->icon_bg    ?? '#eff6ff',
                'icon_color' => $n->icon_color ?? '#1d4ed8',
            ]);

        return view('Admin.Dashboard', compact(
            'totalStaff',
            'totalDepartments',
            'totalUsers',
            'totalPrograms',
            'activePrograms',
            'departments',
            'recentActivity',
        ));
    }
}
