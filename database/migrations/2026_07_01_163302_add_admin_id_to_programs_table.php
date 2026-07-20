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

            $table->foreignId('admin_id')
                ->nullable()
                ->after('created_by')
                ->constrained('admins')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {

            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');

        });
    }
};
