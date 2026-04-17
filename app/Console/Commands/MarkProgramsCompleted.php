<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Program;
use Illuminate\Support\Carbon;
use App\Services\NotificationService;

class MarkProgramsCompleted extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'programs:mark-completed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically mark programs as completed when end_date has passed';

    /**
     * Execute the console command.
     */
    // public function handle(): void
    // {
    //     $now = Carbon::now();

    //     // Mark as COMPLETED — end_date has passed
    //     $completed = Program::whereNotIn('status', ['cancelled', 'completed'])
    //         ->where('end_date', '<', $now)
    //         ->update(['status' => 'completed']);

    //     // Mark as ONGOING — started but not yet ended
    //     $ongoing = Program::whereIn('status', ['upcoming', 'rescheduled'])
    //         ->where('start_date', '<=', $now)
    //         ->where('end_date', '>=', $now)
    //         ->update(['status' => 'ongoing']);

    //     $this->info("Marked {$completed} program(s) as completed.");
    //     $this->info("Marked {$ongoing} program(s) as ongoing.");

    //     $completedPrograms = Program::whereNotIn('status', ['cancelled', 'completed'])
    //         ->where('end_date', '<', $now)
    //         ->get();

    //     foreach ($completedPrograms as $p) {
    //         $p->update(['status' => 'completed']);
    //         // In MarkProgramsCompleted.php, inside the completed loop:
    //         NotificationService::programCompleted($p->created_by, $p->title, $p->id);        }
    // }

    public function handle(): void
    {
        $now = Carbon::now();

        // 1. Mark COMPLETED first — fetch BEFORE updating for notifications
        $completedPrograms = Program::whereNotIn('status', ['cancelled', 'completed'])
            ->where('end_date', '<', $now)
            ->get();

        foreach ($completedPrograms as $p) {
            $p->update(['status' => 'completed']);
            NotificationService::programCompleted($p->created_by, $p->title, $p->id);
        }

        // 2. Mark ONGOING
        $ongoing = Program::whereIn('status', ['upcoming', 'rescheduled'])
            ->where('start_date', '<=', $now)
            ->where('end_date', '>=', $now)
            ->update(['status' => 'ongoing']);

        $this->info("Marked {$completedPrograms->count()} program(s) as completed.");
        $this->info("Marked {$ongoing} program(s) as ongoing.");
    }
}
