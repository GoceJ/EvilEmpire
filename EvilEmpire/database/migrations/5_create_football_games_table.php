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
        Schema::create('football_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('t1_id')->references('id')->on('football_teams');
            $table->foreignId('t2_id')->references('id')->on('football_teams');
            $table->foreignId('points_id')->references('id')->on('football_points');
            $table->foreignId('league_id')->references('id')->on('football_leagues');
            $table->foreignId('home_team')->references('id')->on('football_teams');
            $table->string('match_date');
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
        Schema::dropIfExists('games');
    }
};
