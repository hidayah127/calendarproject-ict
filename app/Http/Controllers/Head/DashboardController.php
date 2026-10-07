<?php

namespace App\Http\Controllers\Head;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $isScc = $user->username === 'amt_scc';

        // amt_scc sees programs from all departments; everyone else only their own
        $programs = Program::query()
            ->when(!$isScc, fn ($q) => $q->where('created_by', $user->id));

        // withStatus() mirrors Program::getStatusAttribute() in SQL
        $totalPrograms = (clone $programs)->count();
        $upcoming      = (clone $programs)->withStatus('upcoming')->count();
        $ongoing       = (clone $programs)->withStatus('ongoing')->count();
        $completed     = (clone $programs)->withStatus('completed')->count();
        $rescheduled   = (clone $programs)->withStatus('rescheduled')->count();
        $cancelled     = (clone $programs)->withStatus('cancelled')->count();

        $recentPrograms = (clone $programs)
            ->with(['staffInCharge', 'department'])
            ->latest()
            ->take(5)
            ->get();

        return view('Head.Dashboard', compact(
            'totalPrograms',
            'upcoming',
            'ongoing',
            'completed',
            'rescheduled',
            'cancelled',
            'recentPrograms',
            'isScc',
        ));
    }
}