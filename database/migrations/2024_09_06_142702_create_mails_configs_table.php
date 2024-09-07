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
        Schema::create('mails_configs', function (Blueprint $table) {
            $table->id();
            $table->string('mail_alert')->nullable(false);
            $table->string('mail_cc1')->nullable(false);
            $table->string('mail_cc2')->nullable(true);
            $table->string('mail_cc3')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mails_configs');
    }
};