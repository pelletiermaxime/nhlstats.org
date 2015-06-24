<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddDivisionToTeams extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->integer('division_id')->unsigned()->nullable();
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign('teams_division_id_foreign');
            $table->dropColumn('division_id');
        });
    }
}
