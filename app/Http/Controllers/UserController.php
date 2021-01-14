<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
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
    if (!Auth::check() || !Auth::user()->hasRole(['admin', 'super_admin'])) {
      return redirect()->route('login')->with('error', 'Authentication Failed!');
    }

    $users = User::with(['roles', 'school', 'schools'])
      ->orderBy('created_at', 'desc')->get();
    return view('pages.user.index')->with('users', $users);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  // public function create()
  // {
  //   if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
  //     return redirect()->back();
  //   }

  //   $permissions = Permission::all();

  //   return view('pages.roles.add')
  //     ->with('permissions', $permissions);
  // }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  // public function store(Request $request)
  // {
  //   if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
  //     return redirect()->back();
  //   }

  //   $input = $request->all();

  //   $validator = Validator::make($request->all(), [
  //     'label' => 'required|string|min:3',
  //     'description' => 'string'
  //   ]);

  //   // validate inputs
  //   if ($validator->fails()) {
  //     return redirect()->route('roles.create')
  //       ->withErrors($validator->errors())
  //       ->withInput($request->all());
  //   } else {
  //     try {
  //       // store
  //       $input['name'] = $request->label ? Str::slug($request->label) : '';
  //       $role = Role::create($input);

  //       // redirect
  //       Session::flash('success', 'Process Successful!');
  //       return redirect()->route('roles.show', $role)->with('role', $role);
  //     } catch (\Throwable $th) {
  //       Session::flash('error', 'Process failed!');
  //       return back()->withErrors($th->getMessage());
  //     }
  //   }
  // }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Category  $consult
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    if (!Auth::check()) {
      return redirect()->route('login')->with('error', 'Authentication Failed!');
    }

    $user =  !Auth::user()->hasRole(['super_admin', 'admin']) ? Auth::user() : User::with(['roles', 'school', 'schools'])->where('id', $id)->first();
    $roles = Role::with('permissions')->get();

    if (isset($user)) {
      return view('pages.user.view')
        ->with('roles', $roles)
        ->with('user', $user);
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
  public function edit(Role $role)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $permissions = Permission::all();

    return view('pages.roles.edit')
      ->with('role', $role)
      ->with('permission', $permissions);
  }


  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Role $role)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    if (!$role) {
      return redirect()->route('roles.index')->with('error', 'Resource not found.');
    }

    $input = $request->input();

    $validator = Validator::make($request->all(), [
      'label' => 'required|string|min:3',
      'description' => 'string'
    ]);


    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      $role->name = $request->name ? Str::slug($request->label) : $role->name;
      $role->label = $request->label ? $request->label : $role->label;
      $role->description = $request->description ? $request->description : $role->description;
      $role->save();

      // redirect
      toast('success', 'Update successful!');
      return redirect()->route('roles.show', $role)->with('role', $role);
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function destroy(Role $role)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $role->delete();

    // redirect
    Session::flash('success', 'Resource deleted!');
    return redirect()->route('roles.index');
  }


  /**
   * assignUserRole
   * removeUserRole
   * assignRolePermission
   * removeRolePermission
   */

  /**
   * Assign roles to user.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function assignUserRole(Request $request, User $user)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $validator = Validator::make($request->all(), [
      'user_id' => 'required',
      'role' => 'required'
    ]);

    $role = Role::where('name', $request->role)->first();

    if ($role) $user->roles()->attach($role->id);

    // redirect
    toast('success', 'Process successful!');
    return redirect()->back();
  }


  /**
   * Assign roles to user.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function removeUserRole(Request $request)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $validator = Validator::make($request->all(), [
      'label' => 'required|string|min:3',
      'description' => 'string'
    ]);



    // redirect
    toast('success', 'Process successful!');
    return redirect()->back();
  }


  /**
   * Assign roles to user.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function assignRolePermission(Request $request)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $validator = Validator::make($request->all(), [
      'label' => 'required|string|min:3',
      'description' => 'string'
    ]);



    // redirect
    toast('success', 'Process successful!');
    return redirect()->back();
  }

  /**
   * Assign roles to user.
   *
   * @param  \App\Models\Timetable  $timetable
   * @return \Illuminate\Http\Response
   */
  public function removeRolePermission(Request $request)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $validator = Validator::make($request->all(), [
      'label' => 'required|string|min:3',
      'description' => 'string'
    ]);



    // redirect
    toast('success', 'Process successful!');
    return redirect()->back();
  }
}
