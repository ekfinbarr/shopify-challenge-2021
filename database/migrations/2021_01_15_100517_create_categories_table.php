<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateCategoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('categories', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('label');
      $table->longText('description')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });

    $categories = ['Personal', 'Public', 'Others'];

    for ($i = 0; $i < count($categories); $i++) {
      DB::table('categories')->insert([
        'name' => Str::slug($categories[$i]),
        'label' => $categories[$i],

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
    Schema::dropIfExists('categories');
  }
}
