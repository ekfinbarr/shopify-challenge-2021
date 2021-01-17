<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateMediaTypesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('media_types', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('label');
      $table->timestamps();
      $table->softDeletes();
    });

    $access_types = ['photo', 'video'];

    for ($i = 0; $i < count($access_types); $i++) {
      DB::table('media_types')->insert([
        'name' => Str::slug($access_types[$i]),
        'label' => $access_types[$i],

        'created_at' => Carbon::now(),
        'updated_at' => Carbon::now(),
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
    Schema::dropIfExists('media_types');
  }
}
