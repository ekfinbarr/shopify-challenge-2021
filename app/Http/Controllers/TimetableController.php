<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\School;
use App\Models\SchoolClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TimetableController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {

      $timetables = !Auth::user()->hasRole(['admin', 'super_admin'])
        ? Timetable::with(['school', 'class'])->where('school_id', Auth::user()->school_id)->orWhere([['created_by', Auth::user()->id], ['is_private', true]])->get()
        : Timetable::with(['school', 'class'])
        ->orWhere('created_by', Auth::user()->id)
        ->where('school_id', Auth::user()->school_id)
        ->get();
      return view('pages.timetable.index')
        ->with('timetables', $timetables);
    } else {
      return redirect()->back()->with('error', 'Authentication failed!');
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
    return view('pages.timetable.add')->with('classes', $classes)->with('schools', $schools);
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

    // $request->is_private = $request->is_private === 'true' ? 1 : 0;

    $input = $request->all();

    $validator = Validator::make($request->all(), [
      'title' => 'required|string|min:3',
    ]);

    // validate inputs
    if ($validator->fails()) {
      return redirect()->route('timetables.create')
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {
        // store
        $input['created_by'] = Auth::user()->id;
        $input['is_private'] = trim($request->is_private) === 'true' ? true : false;
        $timetable = Timetable::create($input);

        // redirect
        Session::flash('success', 'Process Successful!');
        return redirect()->route('timetables.index')->with('timetable', $timetable);
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

    $school = Auth::user()->currentSchool() ? Auth::user()->currentSchool() : null;
    $classes = $school ? $school->classes /*SchoolClass::where('school_id', $school->id)->get()*/ : [];
    $today_lessons = Lesson::where([['timetable_id', $id], ['weekday', Str::lower(date("l"))]])
      ->orderBy('start_time', 'desc')
      ->get();

    $diff = ceil(Carbon::parse('07:30:00')->floatDiffInMinutes('06:30:00'));
    // set the mock
    // dd($diff); 

    $today = [
      'weekday' => date("l"),
      'lessons' => $today_lessons,
      'date' => date("l d-m-Y")
    ];

    $timetable = Timetable::with(['school', 'class', 'lessons'])
      ->where([['created_by', Auth::user()->id], ['id', $id]])
      ->orWhere([['school_id', Auth::user()->school_id], ['id', $id]])
      ->first();

    if (isset($timetable)) {
      return view('pages.timetable.view')
        ->with('timetable', $timetable)
        ->with('school', $school)
        ->with('activity', $today)
        ->with('classes', $classes);
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
  public function edit(Timetable $timetable)
  {
    $classes = SchoolClass::all();
    $schools = School::all();

    if (Auth::user()) {
      return view('pages.timetable.edit')
        ->with('timetable', $timetable)
        ->with('classes', $classes)
        ->with('schools', $schools);
    }
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Timetable $timetable)
  {
    if (!$timetable) {
      return redirect()->route('timetables.index')->with('error', 'Resource not found.');
    }

    // $request->is_private = $request->is_private === 'true' ? 1 : 0;

    $input = $request->input();

    $validator = Validator::make($request->all(), [
      'title' => 'required|string|min:3',
      'description' => 'required|string|min:3'
    ]);


    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      $request['is_private'] = $request->is_private == 'true' ? true : false;
      $timetable->title = $request->title ? $request->title : $timetable->title;
      $timetable->description = $request->description ? $request->description : $timetable->description;
      $timetable->school_id = $request->school_id ? $request->school_id : $timetable->school_id;
      $timetable->class_id = $request->class_id ? $request->class_id : $timetable->class_id;
      $timetable->is_private = isset($request->is_private) ? $request->is_private : $timetable->is_private;
      $timetable->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('timetables.show', $timetable)->with('timetable', $timetable);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function destroy(Timetable $timetable)
  {
    $timetable->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('timetables.index');
  }
}
