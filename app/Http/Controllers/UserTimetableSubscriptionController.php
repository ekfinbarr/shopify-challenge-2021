<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Timetable;
use App\Models\UserTimetableSubscription;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserTimetableSubscriptionController extends Controller
{


  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (Auth::check()) {
      $user = Auth::user();
      $subscriptions = !$user->hasRole(['admin', 'super_admin'])
        ? UserTimetableSubscription::with(['school', 'timetable', 'lesson'])->where([['school_id', $user->school_id], ['user_id', $user->id]])->get()
        : UserTimetableSubscription::with(['school', 'timetable', 'lesson'])->get();
      return view('pages.subscription.index')
        ->with('subscriptions', $subscriptions);
    } else {
      return redirect()->back()->with('error', 'Authentication failed!');
    }
  }


  public function store(Request $request)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    $input = $request->all();

    $validator = Validator::make($request->all(), [
      'timetable_id' => 'required|min:1',
      'lesson_id' => 'required|min:1',
    ]);


    // validate inputs
    if ($validator->fails()) {
      toast('error', 'Process failed. Kindly validate your input!');
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {

      // check duplicate
      if ($this->subscriptionExist(Auth::user()->id, $request->lesson_id)) {
        toast('info', 'Already subscribed!');
        return redirect()->back();
      }

      try {
        $user = Auth::user();
        $input['school_id'] = $user->school_id;
        $input['user_id'] = $user->id;
        $lesson = UserTimetableSubscription::create($input);
        // dd($request->all());
        // redirect
        toast('success', 'Process Successful!');
        return redirect()->back();
      } catch (\Throwable $th) {
        toast('error', 'Process failed!');
        return redirect()->back()->withErrors($th->getMessage());
      }
    }
  }


  private function subscriptionExist($user_id, $lesson_id)
  {
    $sub = UserTimetableSubscription::where([['user_id', $user_id], ['lesson_id', $lesson_id]])->first();

    return $sub ? true : false;
  }


  public function destroy(UserTimetableSubscription $subscription)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    try {
      $subscription->delete();

      // redirect
      Session::flash('success', 'Resource deleted!');
      return redirect()->route('subscriptions.index');
    } catch (\Throwable $th) {
      toast('error', 'Process failed!');
      return redirect()->back()->withErrors($th->getMessage());
    }
  }
}
