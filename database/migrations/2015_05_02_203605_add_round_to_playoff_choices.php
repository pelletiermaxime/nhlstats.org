<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRoundToPlayoffChoices extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('playoff_choices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallInteger('round')->default(1);
            $table->index(['round']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('playoff_choices', function (Blueprint $table) {
            $table->dropColumn('round');
        });
    }
}
