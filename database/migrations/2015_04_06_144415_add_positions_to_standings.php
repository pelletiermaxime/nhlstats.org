<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPositionsToStandings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('standings', function (Blueprint $table) {
            $table->smallInteger('positionOverall')->after('ppoa');
            $table->smallInteger('positionConference')->after('positionOverall');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('standings', function (Blueprint $table) {
            $table->dropColumn('positionOverall');
            $table->dropColumn('positionConference');
        });
    }
}
