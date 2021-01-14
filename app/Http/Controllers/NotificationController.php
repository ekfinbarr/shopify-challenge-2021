<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
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
  public function index()
  {
    if (Auth::check()) {
      $notifications = Auth::user()->notifications;
      return view('pages.notification.index')
        ->with('notifications', $notifications)
        ->with('user', Auth::user());
    } else {
      return view('auth.login')->with('error', 'Authentication Failed!');
    }
  }


  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (Auth::check()) {
      $notification = Auth::user()->notifications->find($id);
      $notification->markAsRead();
      return view('pages.notification.view')
        ->with('user', Auth::user())
        ->with('notification', $notification);
    } else {
      return view('auth.login')->with('error', 'Authentication Failed!');
    }
  }

  /**
   * Mark notification as unread.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function toggleRead(Request $request, $id)
  {

    $validator = Validator::make($request->all(), [
      'status' => 'required|boolean',
    ]);

    // validate inputs
    if ($validator->fails()) {
      toast('error', 'Input validation error!');
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      if (Auth::check()) {
        $notification = Auth::user()->notifications->find($id);
        $request->status ? $notification->markAsRead() : $notification->markAsUnread();
        toast('success', 'Action Completed!');
        return view('pages.notification.index')
          ->with('user', Auth::user())
          ->with('notification', $notification);
      } else {
        return view('auth.login')->with('error', 'Authentication Failed!');
      }
    }
  }



  /**
   * Mark notification as unread.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function toggleSpam(Request $request, $id)
  {

    $validator = Validator::make($request->all(), [
      'status' => 'required|boolean',
    ]);

    // validate inputs
    if ($validator->fails()) {
      toast('error', 'Input validation error!');
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {

      if (Auth::check()) {
        $n = Auth::user()->notifications->find($id);
        if ($n) {
          $notification = DB::table('notifications')->where('id', $n->id)->first();
          if ($notification) {
            DB::update('update notifications set is_spam = ' . $request->status . ' where id = ?', [$n->id]);
            toast('success', 'Action completed!');
            return redirect()->back();
          }
          toast('error', 'Process Failed');
          return redirect()->back();
        }
      } else {
        toast('error', 'Authentication Error!');
        return view('auth.login')->with('error', 'Authentication Failed!');
      }
    }
  }


  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }
    try {
      $n = Auth::user()->notifications->find($id);
      if ($n->id) {
        DB::table('notifications')->where('id', $n->id)->delete();
        // redirect
        toast('success', 'Action completed!');
        return redirect()->route('notifications.index');
      } else {
        toast('error', 'Process failed!');
        return redirect()->back();
      }
    } catch (\Throwable $th) {
      toast('error', 'Process failed!');
      return redirect()->back()->withErrors($th->getMessage());
    }
  }




  public function destroyAll(Request $request)
  {
    $ids = $request->ids;
    DB::table("notifications")->whereIn('id', explode(",", $ids))->delete();

    toast('success', 'Action completed successfully!');
    return redirect()->route('notifications.index');
  }
}
