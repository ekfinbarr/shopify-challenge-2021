<?php

namespace App\Http\Controllers;

use App\Models\MediaFormat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MediaFormatController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $media_formats = MediaFormat::with(['media'])->orderBy('created_at', 'desc')->paginate(10);
      return view('pages.media_format.index')
        ->with('media_formats', $media_formats);
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

    return view('pages.media_format.add');
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
        $media_format = MediaFormat::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->route('media_types.show', $media_format);
      } catch (\Throwable $th) {
        Session::flash('error', 'Process failed!');
        return back()->withErrors($th->getMessage());
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\MediaFormat  $consult
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    $media_format = MediaFormat::with(['media'])->where('id', $id)->first();

    if (isset($media_format)) {
      return view('pages.media_format.view')
        ->with('media_format', $media_format);
    } else {
      toast('error', 'MediaFormat not found!');
      return redirect()->back();
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\MediaFormat  $media_format
   * @return \Illuminate\Http\Response
   */
  public function edit(MediaFormat $media_format)
  {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
      return view('pages.media_format.edit')
        ->with('media_format', $media_format);
    } else {
      return redirect()->back();
    }
  }



  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\MediaFormat  $media_format
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, MediaFormat $media_format)
  {
    if (!$media_format) {
      return redirect()->route('media_formats.index')->with('error', 'Resource not found.');
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
      $media_format->name = $request->title ? Str::slug(Str::lower($request->label)) : $media_format->name;
      $media_format->label = $request->title ? $request->label : $media_format->label;
      $media_format->description = $request->description ? $request->description : $media_format->description;
      $media_format->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('media_formats.show', $media_format)->with('media_format', $media_format);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\MediaFormat  $media_format
   * @return \Illuminate\Http\Response
   */
  public function destroy(MediaFormat $media_format)
  {
    if (!Auth::check() || !Auth::user()->hasRole('admin')) return redirect()->back();
    $media_format->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('media_formats.index');
  }
}
