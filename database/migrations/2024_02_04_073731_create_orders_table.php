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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id',20)->nullable();
            $table->string('billiards')->comment('название бильярдной');
            $table->string('idd')->nullable();
            $table->string('recToken')->nullable();
            $table->integer('summa');
            $table->tinyInteger('isBar')->default(1)->comment('1-yes 0-not');
            $table->integer('month')->default(12);
            $table->tinyInteger('paid')->default(0)->comment('оплачено 1-yes 0-not');
            $table->tinyInteger('is_way_active')->default(0);
            $table->tinyInteger('regularCount',3)->nullable()->unsigned();
            $table->integer('user_id')->nullable();
            $table->integer('rate_id')->nullable();
            $table->integer('billiard_id')->nullable();
            $table->string('valuta',100)->default('UAH');
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
