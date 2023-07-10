<?php

use App\Models\Place;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlaceIdInFloorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('floors', function (Blueprint $table) {
            $place_id = Place::first()->id;
            $table->foreignId('place_id')->default($place_id)->after('id')->constrained();
            $table->unique(['place_id', 'name']);
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
            $table->dropUnique(['place_id', 'name']);
            $table->dropColumn('place_id');
        });
    }
}
