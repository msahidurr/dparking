<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUniqueKeyInFloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('floors', function (Blueprint $table) {
            $table->dropUnique('floors_name_unique');
            $table->unique(['place_id', 'name'], 'floors_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('floors', function (Blueprint $table) {
            $table->dropForeign(['place_id']);
            $table->dropUnique('floors_name_unique');
            $table->foreign('place_id')->references('id')->on('places');
            $table->unique('name');
        });
    }
}
