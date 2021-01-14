<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $schools = School::with('classes')->where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(8);
      return view('pages.school.index')
        ->with('schools', $schools);
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
    
    return view('pages.school.add')
      ->with('classes', $classes)
      ->with('countries', config('countries'))
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
      'name' => 'required|string|min:3',
      'description' => 'required|string|min:3',
      'address' => 'string|min:3',
      'country' => 'string|min:2',
      'email' => 'string',
    ]);

    // validate inputs
    if ($validator->fails()) {
      return redirect()->route('schools.create')
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {
        // store
        $input['id'] = uniqid("DTS", false);
        $input['created_by'] = Auth::user()->id;
        $school = School::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->route('schools.show', $school)->with('school', $school);
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

    $school = School::with('classes')->where('id', $id)->first();

    if (isset($school)) {
      return view('pages.school.view')
        ->with('school', $school);
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
  public function edit(School $school)
  {
    $classes = SchoolClass::all();
    $schools = School::all();

    if (Auth::user()) {
      return view('pages.school.edit')
        ->with('school', $school)
        ->with('countries', config('countries'))
        ->with('classes', $classes);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function setActiveSchool($id)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    if($id) {
      $user = User::find(Auth::user()->id);
      if($user) {
        $user->school_id = $id;
        $user->save();
      }
      // Auth::user()->school_id = $school->id;
      // redirect
      toast('success', 'Process successful!');
      return redirect()->back();
    } else {
      toast('error', 'Process failed!');
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, School $school)
  {
    if (!$school) {
      return redirect()->route('schools.index')->with('error', 'Resource not found.');
    }

    // $request->is_private = $request->is_private === 'true' ? 1 : 0;

    $input = $request->input();

    $validator = Validator::make($request->all(), [
      'name' => 'required|string|min:3',
      'description' => 'required|string|min:3',
      'address' => 'string|min:3',
      'country' => 'string|min:2',
      'email' => 'string'
    ]);


    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      $school->name = $request->name ? $request->name : $school->title;
      $school->description = $request->description ? $request->description : $school->description;
      $school->address = $request->address ? $request->address : $school->address;
      $school->country = $request->country ? $request->country : $school->country;
      $school->email = $request->email ? $request->email : $school->email;
      $school->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('schools.show', $school)->with('school', $school);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function destroy(School $school)
  {
    $school->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('schools.index');
  }
}
