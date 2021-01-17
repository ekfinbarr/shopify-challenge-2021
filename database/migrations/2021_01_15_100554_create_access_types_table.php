<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateAccessTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('label');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
    });

    $access_types = ['public', 'private'];

    for ($i = 0; $i < count($access_types); $i++) {
      DB::table('access_types')->insert([
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
        Schema::dropIfExists('access_types');
    }
}
