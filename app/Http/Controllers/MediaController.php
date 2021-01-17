<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MediaController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $photos = Media::with(['user', 'category', 'tags'])->orderBy('created_at', 'desc')->paginate(10);
      return view('pages.media.index')
        ->with('photos', $photos);
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

    return view('pages.media.add');
  }



  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!Auth::check() || !Auth::user()->hasRole('admin')) {
      return redirect()->back();
    }


    $input = $request->all();

    $validator = Validator::make($request->all(), [
      'label' => 'string|min:3',
      'description' => 'string|nullable'
    ]);

    // validate inputs
    if ($validator->fails()) {
      Session::flash('error', 'Kindly check your inputs and try again!');
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {

        // store
        $input['name'] = isset($input['label']) ? Str::slug(Str::lower($input['label'])) : '';
        $photo = Media::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->view('pages.media.index');
      } catch (\Throwable $th) {
        Session::flash('error', 'Process failed!');
        return back()->withErrors($th->getMessage());
      }
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
    $photo = Media::with(['user', 'category','tags'])->where('id', $id)->first();
    
    if (isset($photo)) {
      $related_photos = Media::where('category_id', $photo->category_id)->limit(8)->get();

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
      return view('pages.media.edit')
        ->with('photo', $photo);
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
    if (!Auth::check() || !Auth::user()->hasRole('admin')) return redirect()->back();
    $photo->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('photos.index');
  }
}
