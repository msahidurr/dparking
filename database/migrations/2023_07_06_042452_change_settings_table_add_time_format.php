<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeSettingsTableAddTimeFormat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('date_format')->default('m-d-Y H:i:s')->nullable()->after('translation');
            $table->string('date_format_sql')->default('%m-%d-%Y %H:%i:%s')->nullable()->after('date_format');
            $table->string('app_timezone')->default('UTC')->nullable()->after('date_format_sql');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('date_format');
            $table->dropColumn('date_format_sql');
            $table->dropColumn('app_timezone');
        });
    }
}
