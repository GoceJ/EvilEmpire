<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('t1_coef');
            $table->foreignId('t2_coef');
            $table->foreignId('t1_q1');
            $table->foreignId('t1_q2');
            $table->foreignId('t1_q3');
            $table->foreignId('t1_q4');
            $table->foreignId('t2_q1');
            $table->foreignId('t2_q2');
            $table->foreignId('t2_q3');
            $table->foreignId('t2_q4');
            $table->foreignId('t1_first_half');
            $table->foreignId('t1_second_half');
            $table->foreignId('t2_first_half');
            $table->foreignId('t2_second_half');
            $table->foreignId('t1_total');
            $table->foreignId('t2_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points');
    }
};
