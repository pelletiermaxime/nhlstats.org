<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFulltextIndexToPlayers extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement('ALTER TABLE players ADD FULLTEXT full_name(full_name)');
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropIndex('full_name');
        });
    }
}
