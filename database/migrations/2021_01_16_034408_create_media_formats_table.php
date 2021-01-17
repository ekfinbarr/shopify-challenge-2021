<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaFormatsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('media_formats', function (Blueprint $table) {
      $table->id();
      $table->string('name')->unique();
      $table->string('label');
      $table->text('description')->nullable();
      $table->timestamps();
      $table->softDeletes();
    });

    $media_formats = [
      'JPEG',
      'JPG',
      'PNG',
      'GIF',
      'TIFF',
      'PSD',
      'PDF',
      'EPS',
      'AI',
      'INDD',
      'RAW',
      'BMP',
      'SVG',
      'CGM'
    ];
    $media_format_description = [
      'Joint Photographic Experts Group',
      'Joint Photographic Experts Group',
      'Portable Network Graphics',
      'Graphics Interchange Format',
      'Tagged Image File',
      'Photoshop Document',
      'Portable Document Format',
      'Encapsulated Postscript',
      'Adobe Illustrator Document',
      'Adobe Indesign Document',
      'Raw Image Formats',
      'Windows Bitmap',
      'Scalable Vector Graphics',
      'Computer Graphics Metafile'
    ];

    for ($i = 0; $i < count($media_formats); $i++) {
      DB::table('media_formats')->insert([
        'name' => Str::slug(Str::lower($media_formats[$i])),
        'label' => $media_formats[$i],
        'description' => $media_format_description[$i],

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
    Schema::dropIfExists('media_formats');
  }
}
