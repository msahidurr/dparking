<?php

use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaltColumnInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('salt', 100)->nullable()->after('password');
        });

        $role_admin = new Role();
	    $role_admin->name = 'admin';
	    $role_admin->description = 'Admin User';
	    $role_admin->save();

	    $role_reviewer = new Role();
	    $role_reviewer->name = 'operator';
	    $role_reviewer->description = 'Operator';
	    $role_reviewer->save();

        $role_admin 		 = Role::where('name', 'admin')->first();

	    $admin = new User();

	    $admin->name = 'Admin Name';
	    $admin->email = 'admin@gmail.com';
	    $admin->status = 1;
	    $admin->password = bcrypt('123456');
	    $admin->save();

	    $admin->roles()->attach($role_admin);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('salt');
        });
    }
}
