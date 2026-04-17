<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL requires re-declaring the full enum to modify it
        DB::statement("
            ALTER TABLE programs
            MODIFY COLUMN status ENUM('upcoming','ongoing','completed','cancelled','rescheduled')
            NOT NULL DEFAULT 'upcoming'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original 4 values
        // Note: any rows with 'rescheduled' will need to be handled first
        DB::statement("
            UPDATE programs SET status = 'upcoming' WHERE status = 'rescheduled'
        ");

        DB::statement("
            ALTER TABLE programs
            MODIFY COLUMN status ENUM('upcoming','ongoing','completed','cancelled')
            NOT NULL DEFAULT 'upcoming'
        ");
    }
};
