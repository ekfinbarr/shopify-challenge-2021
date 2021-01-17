<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TagController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $tags = Tag::with(['media'])->orderBy('created_at', 'desc')->paginate(10);
      return view('pages.tag.index')
        ->with('tags', $tags);
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

    return view('pages.tag.add');
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
        $tag = Tag::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->view('pages.tag.index');
      } catch (\Throwable $th) {
        Session::flash('error', 'Process failed!');
        return back()->withErrors($th->getMessage());
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Tag  $consult
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    $tag = Tag::with(['media'])->where('id', $id)->first();

    if (isset($tag)) {
      return view('pages.tag.view')
        ->with('tag', $tag);
    } else {
      toast('error', 'Tag not found!');
      return redirect()->back();
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function edit(Tag $tag)
  {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
      return view('pages.tag.edit')
        ->with('tag', $tag);
    } else {
      return redirect()->back();
    }
  }



  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Tag $tag)
  {
    if (!$tag) {
      return redirect()->route('tags.index')->with('error', 'Resource not found.');
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
      $tag->name = $request->title ? Str::slug(Str::lower($request->label)) : $tag->name;
      $tag->label = $request->title ? $request->label : $tag->label;
      $tag->description = $request->description ? $request->description : $tag->description;
      $tag->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('tags.show', $tag)->with('tag', $tag);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Tag  $tag
   * @return \Illuminate\Http\Response
   */
  public function destroy(Tag $tag)
  {
    if (!Auth::check() || !Auth::user()->hasRole('admin')) return redirect()->back();
    $tag->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('tags.index');
  }
}
