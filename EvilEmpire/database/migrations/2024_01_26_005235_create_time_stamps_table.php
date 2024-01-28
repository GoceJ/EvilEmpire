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
        Schema::create('time_stamps', function (Blueprint $table) {
            $table->id();
            $table->string('time_stamp')->default('0');
            $table->boolean('basket_import')->default(false);
            $table->boolean('player_import')->default(false);
            $table->boolean('football_import')->default(false);
            $table->boolean('basket_error')->default(false);
            $table->boolean('player_error')->default(false);
            $table->boolean('football_error')->default(false);
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
        Schema::dropIfExists('time_stamps');
    }
};
