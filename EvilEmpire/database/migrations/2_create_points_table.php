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
            $table->string('t1_coef');
            $table->string('t2_coef');
            $table->string('t1_q1');
            $table->string('t1_q2');
            $table->string('t1_q3');
            $table->string('t1_q4');
            $table->string('t2_q1');
            $table->string('t2_q2');
            $table->string('t2_q3');
            $table->string('t2_q4');
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
