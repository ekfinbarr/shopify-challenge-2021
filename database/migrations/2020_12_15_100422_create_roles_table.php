<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label');
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // predefined roles
        $roles = ['admin', 'user', 'teacher', 'student', 'super admin'];
        $faker = Faker::create();
        for ($i = 0; $i < count($roles); $i++) {
            DB::table('roles')->insert([
                'name' => Str::slug($roles[$i]),
                'label' => $roles[$i]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
