<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfidVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfid_vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id');
            $table->string('vehicle_no',12);
            $table->string('rfid_no',24);
            $table->string('driver_name')->nullable();
            $table->string('driver_mobile')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('created_by');
            $table->foreignId('modified_by')->nullable();
            $table->unique(['category_id','vehicle_no']);
            $table->unique(['category_id','rfid_no']);
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rfid_vehicles');
    }
}
