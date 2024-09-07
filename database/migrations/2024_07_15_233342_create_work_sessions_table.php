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
        Schema::create('work_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('pc_work');
            $table->timestamp('wkstart_time')->nullable();
            $table->timestamp('wkend_time')->nullable();
            $table->timestamp('lunch_start_time')->nullable()->default(null);
            $table->timestamp('lunch_end_time')->nullable()->default(null);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('no action');
            $table->foreign('pc_work')->references('id')->on('pcs')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_sessions');
    }
};