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
        Schema::create('football_points', function (Blueprint $table) {
            $table->id();
            $table->string('t1_coef');
            $table->string('xcoef');
            $table->string('t2_coef');
            $table->string('t1_1half');
            $table->string('t1_total');
            $table->string('t2_1half');
            $table->string('t2_total');
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
