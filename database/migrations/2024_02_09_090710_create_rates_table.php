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
        Schema::create('rates', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->boolean('isBar')->default(1)->comment('0-без бара 1- с баром');
            $table->unsignedBigInteger('month');
            $table->unsignedBigInteger('year');
            $table->unsignedBigInteger('billiard_id')->nullable();
            $table->string('valuta',100)->default('UAH');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
