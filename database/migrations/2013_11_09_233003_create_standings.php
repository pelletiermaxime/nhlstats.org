<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStandings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('standings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('team_id')->unsigned()->nullable();
            $table->smallInteger('year');
            $table->smallInteger('gp');
            $table->smallInteger('w');
            $table->smallInteger('l');
            $table->smallInteger('otl');
            $table->smallInteger('pts');
            $table->smallInteger('gf');
            $table->smallInteger('ga');
            $table->float('ppp');
            $table->float('pkp');
            $table->string('home', 10);
            $table->string('away', 10);
            $table->string('l10', 10);
            $table->string('diff', 5);
            $table->string('streak', 10);
            $table->smallInteger('ppg');
            $table->smallInteger('ppo');
            $table->smallInteger('ppga');
            $table->smallInteger('ppoa');

            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->index(['year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('standings');
    }
}
