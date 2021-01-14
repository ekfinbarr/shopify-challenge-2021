<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SchoolClassController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $classes = SchoolClass::with(['lessons', 'school'])->where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);
      return view('pages.class.index')
        ->with('classes', $classes);
    } else {
      return redirect()->back()->with('error', 'Authentication Failed!');
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

    $classes = SchoolClass::all();
    $schools = School::all();

    if (!Auth::check()) {
      return redirect()->back();
    }
    return view('pages.class.add')
      ->with('classes', $classes)
      ->with('schools', $schools);
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
      'label' => 'required|string|min:3',
      'school_id' => 'required|min:1'
    ]);

    // validate inputs
    if ($validator->fails()) {
      return redirect()->route('classes.create')
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {
        // store
        $input['created_by'] = Auth::user()->id;
        $input['name'] = Str::slug($request->label);
        $class = SchoolClass::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->route('classes.show', $class)->with('class', $class);
      } catch (\Throwable $th) {
        toast('error', 'Process failed!');
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

    $class = SchoolClass::with(['lessons', 'school'])->where('id', $id)->first();

    if (isset($class)) {
      return view('pages.class.view')
        ->with('class', $class);
    } else {
      toast('error', 'Resource not found!');
      return redirect()->back();
    }
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function edit(SchoolClass $class)
  {
    $schools = School::all();

    if (Auth::user()) {
      return view('pages.class.edit')
        ->with('schools', $schools)
        ->with('class', $class);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, SchoolClass $class)
  {
    if (!$class) {
      return redirect()->route('classes.index')->with('error', 'Resource not found.');
    }

    $validator = Validator::make($request->all(), [
      'label' => 'required|string|min:3',
      'school_id' => 'min:1'
    ]);


    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      $class->name = isset($request->label) ? Str::slug($request->label) : $class->name;
      $class->label = $request->label ? $request->label : $class->label;
      $class->school_id = $request->school_id ? $request->school_id : $class->school_id;
      $class->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('classes.show', $class)->with('class', $class);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function destroy(SchoolClass $class)
  {
    $class->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('classes.index');
  }
}
