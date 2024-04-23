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
        Schema::create('connection_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignId('server_id')->constrained('servers');
            $table->boolean('alive');
            $table->float('pingms')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('connection_logs');
    }
};
