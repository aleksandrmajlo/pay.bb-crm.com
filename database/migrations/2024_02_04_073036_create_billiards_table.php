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
        Schema::create('billiards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('idd');
            $table->tinyInteger('isBar')->default(1)->comment('1- c баром, 0-без него');
            $table->tinyInteger('isFree')->default(0)->comment();
            $table->date('date_end')->nullable();
            $table->string('valuta',100)->default('UAH');
            $table->text('comment')->nullable();
            $table->json('rate_ids')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billiards');
    }
};
