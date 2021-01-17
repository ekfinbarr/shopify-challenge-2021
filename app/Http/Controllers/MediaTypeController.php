<?php

namespace App\Http\Controllers;

use App\Models\MediaType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MediaTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $media_types = MediaType::with(['media'])->orderBy('created_at', 'desc')->paginate(10);
      return view('pages.media_type.index')
        ->with('media_types', $media_types);
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

    return view('pages.media_type.add');
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
        $media_type = MediaType::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->view('pages.media_type.index');
      } catch (\Throwable $th) {
        Session::flash('error', 'Process failed!');
        return back()->withErrors($th->getMessage());
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\MediaType  $consult
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    $media_type = MediaType::with(['media'])->where('id', $id)->first();

    if (isset($media_type)) {
      return view('pages.media_type.view')
        ->with('media_type', $media_type);
    } else {
      toast('error', 'MediaType not found!');
      return redirect()->back();
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\MediaType  $media_type
   * @return \Illuminate\Http\Response
   */
  public function edit(MediaType $media_type)
  {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
      return view('pages.media_type.edit')
        ->with('media_type', $media_type);
    } else {
      return redirect()->back();
    }
  }



  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\MediaType  $media_type
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, MediaType $media_type)
  {
    if (!$media_type) {
      return redirect()->route('media_types.index')->with('error', 'Resource not found.');
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
      $media_type->name = $request->title ? Str::slug(Str::lower($request->label)) : $media_type->name;
      $media_type->label = $request->title ? $request->label : $media_type->label;
      $media_type->description = $request->description ? $request->description : $media_type->description;
      $media_type->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('media_types.show', $media_type)->with('media_type', $media_type);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\MediaType  $media_type
   * @return \Illuminate\Http\Response
   */
  public function destroy(MediaType $media_type)
  {
    if (!Auth::check() || !Auth::user()->hasRole('admin')) return redirect()->back();
    $media_type->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('media_types.index');
  }
}
