<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware(['auth','verified']);
  }

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    // if(!Auth::check()) {

    // }
    // $routeName = Auth::check() && (Auth::user()->hasRole(['admin','student','teacher'])) ? 'dashboard' : 'home';
    // if (session('status')) {
    //   return redirect()->route($routeName)->with('status', session('status'));
    // }
    
    return view('pages.index')->with('dashboard', $this->getDashboardInfo());
  }

  public function getDashboardInfo()
  {
    if(!Auth::check()) {
      Session::flash('error', 'Please login to continue!');
      return redirect()->route('login');
    }

    $timetables = Auth::user()->timetables;
    $lessons = Auth::user()->lessons;
    $classes = Auth::user()->classes;

    return [
      'timetables' => $timetables,
      'lessons' => $lessons,
      'classes' => $classes
    ];
  }
}
