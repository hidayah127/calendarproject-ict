<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('program_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->enum('role', [
                'committee_member',
                'committee_head',
                'coordinator',
                'facilitator',
                'secretary',
                'treasurer',
            ])->default('committee_member');
            $table->string('responsibility')->nullable(); // Specific task/scope assigned
            $table->boolean('is_lead')->default(false);   // Flags the primary PIC if needed
            $table->timestamps();

            $table->unique(['program_id', 'staff_id']); // Prevent duplicate assignment
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_staff');
    }
};
