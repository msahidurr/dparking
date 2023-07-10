<?php

use App\Models\Category;
use App\Models\Place;
use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->mediumText('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        
        
        Schema::table('categories', function (Blueprint $table) {
            $user = User::first();
            $place = Place::create(['name' => 'Default Place', 'created_by' => $user->id]);
            $table->dropUnique(['type']);
            $table->foreignId('place_id')->default($place->id)->after('id')->nullable()->constrained()->onDelete('cascade');
            $table->unique(['place_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['place_id']);
            $table->dropUnique(['place_id', 'type']);
            $table->unique('type');
            $table->dropColumn('place_id');
        });

        Schema::dropIfExists('places');
    }
}
