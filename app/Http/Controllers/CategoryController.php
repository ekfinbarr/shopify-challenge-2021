<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $categories = Category::with(['media'])->orderBy('created_at', 'desc')->paginate(10);
      return view('pages.category.index')
        ->with('categories', $categories);
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

    return view('pages.category.add');
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
        $category = Category::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->view('pages.category.index');
      } catch (\Throwable $th) {
        Session::flash('error', 'Process failed!');
        return back()->withErrors($th->getMessage());
      }
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Category  $consult
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    $category = Category::with(['media'])->where('id', $id)->first();

    if (isset($category)) {
      return view('pages.category.view')
        ->with('category', $category);
    } else {
      toast('error', 'Category not found!');
      return redirect()->back();
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function edit(Category $category)
  {
    if (Auth::check() && Auth::user()->hasRole('admin')) {
      return view('pages.category.edit')
        ->with('category', $category);
    } else {
      return redirect()->back();
    }
  }



  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Category $category)
  {
    if (!$category) {
      return redirect()->route('categories.index')->with('error', 'Resource not found.');
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
      $category->name = $request->title ? Str::slug(Str::lower($request->label)) : $category->name;
      $category->label = $request->title ? $request->label : $category->label;
      $category->description = $request->description ? $request->description : $category->description;
      $category->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('categories.show', $category)->with('category', $category);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Category  $category
   * @return \Illuminate\Http\Response
   */
  public function destroy(Category $category)
  {
    if (!Auth::check() || !Auth::user()->hasRole('admin')) return redirect()->back();
    $category->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('categories.index');
  }
}
