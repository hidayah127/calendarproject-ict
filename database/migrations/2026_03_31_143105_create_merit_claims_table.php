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
        Schema::create('merit_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');

            $table->enum('claim_type', [
                'attendee',          // just attended the program
                'committee_member',
                'committee_head',
                'coordinator',
                'secretary',
                'treasurer',
                'facilitator',
            ])->default('attendee');

            $table->integer('merit_points')->default(0);  // auto-set based on claim_type
            $table->string('proof_path')->nullable();      // uploaded file path
            $table->string('proof_original_name')->nullable();

            $table->enum('status', [
                'pending',   // submitted, awaiting review
                'approved',  // merit awarded
                'rejected',  // rejected with reason
            ])->default('pending');

            $table->text('rejection_reason')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // One claim per staff per program per type
            $table->unique(['staff_id', 'program_id', 'claim_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merit_claims');
    }
};
