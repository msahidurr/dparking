<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->tinyInteger('role_id')->nullable();
            $table->integer('driver_owner_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('commune_id')->nullable();
            $table->string('driver_owner_name')->nullable();
            $table->string('owner_phone_no')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('id_number')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('tariff_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumns([
                'address',
                'phone_number',
                'role_id',
                'driver_owner_id',
                'owner_phone_no',
                'category_id',
                'id_number',
                'vehicle_no',
                'driver_owner_name',
                'tariff_id',
            ]);
        });
    }
}
