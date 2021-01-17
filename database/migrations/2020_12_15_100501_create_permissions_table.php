<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class CreatePermissionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('permissions', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('label');
      $table->timestamps();
      $table->softDeletes();
    });

    // predefined permissions
    $permissions = ['user_management_access', 'permission_create', 'permission_edit', 'permission_show', 'permission_delete', 'permission_access', 'role_create', 'role_edit', 'role_show', 'role_delete', 'role_access', 'user_create', 'user_edit', 'user_show', 'user_delete', 'user_access', 'media_create', 'media_edit', 'media_show', 'media_delete', 'media_access', 'media_sale'];
    $faker = Faker::create();
    for ($i = 0; $i < count($permissions); $i++) {
      DB::table('permissions')->insert([
        'name' => Str::slug($permissions[$i]),
        'label' => $permissions[$i]
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
    Schema::dropIfExists('permissions');
  }
}
