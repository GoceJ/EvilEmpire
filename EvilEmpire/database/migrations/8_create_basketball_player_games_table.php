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
        Schema::create('basketball_player_games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('league_id')->references('id')->on('basketball_leagues');
            $table->foreignId('player_id')->references('id')->on('basketball_players');
            $table->foreignId('team_id')->references('id')->on('basketball_teams');
            $table->foreignId('score_id')->references('id')->on('basketball_scores');
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
        Schema::dropIfExists('player_games');
    }
};
