<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\AccessType;
use App\Models\Category;
use App\Models\MediaFormat;
use App\Models\MediaType;
use App\Models\Tag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Traits\FileUploadTrait;

class MediaController extends Controller
{
  use FileUploadTrait;
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $photos = Media::with(['user', 'category', 'tags'])
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
      if ($request->search !== "") {
        $photos = Media::with(['user', 'category', 'tags'])
          ->where('user_id', Auth::user()->id)
          ->where('name', 'LIKE', '%' . $request->search . '%')
          ->orWhere('description', 'LIKE', '%' . $request->search . '%')
          ->orderBy("updated_at", "desc")
          ->get();
      }
      return view("pages.media.index")->with("photos", $photos);
    } else {
      return view('auth.login')->with('error', 'Authentication Failed!');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    if (!Auth::check()) {
      return redirect()->back();
    }
    $media_formats = MediaFormat::all();
    $media_types = MediaType::all();
    $categories = Category::all();
    $access_types = AccessType::all();
    $tags = Tag::all();
    return view('pages.media.add')
      ->with("categories", $categories)
      ->with("media_formats", $media_formats)
      ->with("media_types", $media_types)
      ->with("access_types", $access_types)
      ->with("tags", $tags);
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }


    $input = $request->all();

    $validator = Validator::make($request->all(), [
      'label' => 'string|min:3',
      'description' => 'string|nullable',
      'image' => 'required|image|file'
    ]);

    // validate inputs
    if ($validator->fails()) {
      Session::flash('error', 'Kindly check your inputs and try again!');
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {
        // get dimensions
        $data = getimagesize($request->image);
        $width = $data[0];
        $height = $data[1];
        $type = $data[2];
        $attr = $data[3];

        // store
        $input['file'] = $this->getBaseUrl() . $this->uploadFile($request->image, 'media-photos');
        $input['published'] = $request->published == 'true' || true ? 1 : 0;
        $input['dimension'] = $width . ',' . $height;
        $input['slug'] = $input['file'];
        $input['name'] = !isset($input['name']) || $input['name'] == '' ? date('Y') . "_" . $request->image->getClientOriginalName() : '';
        $input['user_id'] = Auth::user()->id;
        $photo = Media::create($input);

        // redirect
        toast('success', 'Image Upload Successful!');
        return $this->index(new Request(['search' => '']));
      } catch (\Throwable $th) {
        Session::flash('error', 'Process failed!');
        return back()->withErrors($th->getMessage());
      }
    }
  }


  /**
   * Format bytes to kb, mb, gb, tb
   *
   * @param  integer $size
   * @param  integer $precision
   * @return integer
   */
  public static function formatBytes($size, $precision = 2)
  {
    if ($size > 0) {
      $size = (int) $size;
      $base = log($size) / log(1024);
      $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

      return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
    } else {
      return $size;
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Media  $consult
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $photo = Media::with(['user', 'category', 'tags'])->where('id', $id)->first();

    if (isset($photo)) {
      $related_photos = Media::public()->published()->where([['id', '!=', $photo->id],['category_id', $photo->category_id]])->limit(8)->get();

      return view('landing.media.view')
        ->with('related_photos', $related_photos)
        ->with('media', $photo);
    } else {
      toast('error', 'Photo not found!');
      return redirect()->back();
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Media  $photo
   * @return \Illuminate\Http\Response
   */
  public function edit(Media $photo)
  {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
      $media_formats = MediaFormat::all();
      $media_types = MediaType::all();
      $categories = Category::all();
      $access_types = AccessType::all();
      $tags = Tag::all();
      return view('pages.media.edit')
        ->with("categories", $categories)
        ->with("media_formats", $media_formats)
        ->with("media_types", $media_types)
        ->with("access_types", $access_types)
        ->with('photo', $photo)
        ->with("tags", $tags);
    } else {
      return redirect()->back();
    }
  }



  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Media  $photo
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Media $photo)
  {
    if (!$photo) {
      return redirect()->route('photos.index')->with('error', 'Resource not found.');
    }

    $validator = Validator::make($request->all(), [
      'label' => 'required|string|min:3',
      'description' => 'required|string|min:3'
    ]);


    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      $photo->name = $request->title ? Str::slug(Str::lower($request->label)) : $photo->name;
      $photo->label = $request->title ? $request->label : $photo->label;
      $photo->description = $request->description ? $request->description : $photo->description;
      $photo->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('photos.show', $photo)->with('photo', $photo);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Media  $photo
   * @return \Illuminate\Http\Response
   */
  public function destroy(Media $photo)
  {
    if (!Auth::check()) {
      toast("error", "Authentication Error!");
      return redirect()->back();
    }
    if (Auth::user()->hasMedia($photo->id)) {
      $photo->delete();
      // redirect
      Session::flash('success', 'Resource deleted!');
      return redirect()->route('media.index');
    } else {
      toast("error", "Unauthorized action!. You have no right over this resource");
      return redirect()->back();
    }
  }
}
