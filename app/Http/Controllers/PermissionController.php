<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if (!Auth::check()) {
      return redirect()->back();
    }

    if (Auth::check()) {
      // $roles = Permission::with(['roles'])->orderBy('created_at', 'desc')->paginate(10);
      // return view('pages.roles.index')
      //   ->with('roles', $roles);
    } else {
      return redirect()->back()->with('error', 'Authentication Failed!');
    }
  }

}

