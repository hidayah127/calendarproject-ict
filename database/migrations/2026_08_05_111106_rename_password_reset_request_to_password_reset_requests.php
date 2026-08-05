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
         Schema::rename('password_reset_request', 'password_reset_requests');
    }

    /**
     * Reverse the migrations.
     */
   public function reverse(): void
    {
        Schema::rename('password_reset_requests', 'password_reset_request');
    }
};
