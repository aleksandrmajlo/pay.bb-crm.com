<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billiard_sms_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('billiard_id')->unique()->constrained('billiards')->cascadeOnDelete();
            $table->string('turbosms_login')->nullable();
            $table->text('turbosms_password')->nullable();
            $table->string('twillo_sid')->nullable();
            $table->text('twillo_token')->nullable();
            $table->string('twillo_from')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billiard_sms_settings');
    }
};
