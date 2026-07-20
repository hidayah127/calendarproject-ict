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
        Schema::table('programs', function (Blueprint $table) {

            // Remove old foreign key
            $table->dropForeign(['created_by']);

            // Remove old column
            $table->dropColumn('created_by');

            // Add new columns
            $table->foreignId('admin_id')
                  ->nullable()
                  ->after('category')
                  ->constrained('admins')
                  ->nullOnDelete();

            $table->foreignId('user_id')
                  ->nullable()
                  ->after('admin_id')
                  ->constrained('users')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {

            $table->dropForeign(['admin_id']);
            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'admin_id',
                'user_id'
            ]);

            $table->foreignId('created_by')
                  ->constrained('users');
        });
    }
};
