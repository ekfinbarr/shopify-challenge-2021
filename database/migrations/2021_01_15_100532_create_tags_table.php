<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateTagsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('tags', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('label');
      $table->timestamps();
      $table->softDeletes();
    });

    $tags = [
      'science',
      'art',
      'politics',
      'love',
      'fashion',
      'beautiful',
      'photooftheday',
      'artist',
      'happy',
      'photography',
      'followme',
      'tbt',
      'nature',
      'like4like',
      'travel',
      'instagram',
      'repost',
      'style',
      'me',
      'friends',
      'friend',
      'fitness',
      'mall',
      'beach',
      'wildlife',
      'games',
      'sport',
      'social',
      'worship',
      'school',
      'church'
    ];

    for ($i = 0; $i < count($tags); $i++) {
      DB::table('tags')->insert([
        'name' => Str::slug(Str::lower($tags[$i])),
        'label' => $tags[$i],

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
    Schema::dropIfExists('tags');
  }
}
