<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeUniqueKeyInCategoryWiseFloorSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_wise_floor_slots', function (Blueprint $table) {
            $table->dropForeign(['floor_id']);
            $table->dropUnique(["floor_id", "category_id", "slot_name"]);

            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('cascade');
            $table->unique(["place_id", "floor_id", "category_id", "slot_name"], 'slot_name_unique');
            
            $table->dropUnique(['slotId']);
            $table->unique(["place_id", "slotId"], 'category_wise_floor_slots_slotid_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_wise_floor_slots', function (Blueprint $table) {
            $table->dropForeign(['floor_id']);
            $table->dropForeign(['place_id']);
            $table->dropUnique('slot_name_unique');
            
            $table->foreign('floor_id')->references('id')->on('floors')->onDelete('cascade');
            $table->unique(["floor_id", "category_id", "slot_name"]);
            
            $table->dropUnique('category_wise_floor_slots_slotid_unique');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->unique('slotId');
        });
    }
}
