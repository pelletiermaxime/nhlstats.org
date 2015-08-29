<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddRowToStandings extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('standings', function (Blueprint $table) {
            $table->smallInteger('row')
                ->after('pts')
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('standings', function (Blueprint $table) {
            $table->dropColumn('row');
        });
    }
}
