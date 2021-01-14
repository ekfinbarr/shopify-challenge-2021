<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
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
      $roles = Role::with(['permissions'])->orderBy('created_at', 'desc')->paginate(10);
      return view('pages.roles.index')
        ->with('roles', $roles);
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
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $permissions = Permission::all();

    return view('pages.roles.add')
      ->with('permissions', $permissions);
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $input = $request->all();

    $validator = Validator::make($request->all(), [
      'label' => 'required|string|min:3',
      'description' => 'string'
    ]);

    // validate inputs
    if ($validator->fails()) {
      return redirect()->route('roles.create')
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      try {
        // store
        $input['name'] = $request->label ? Str::slug($request->label) : '';
        $role = Role::create($input);

        // redirect
        toast('success', 'Process Successful!');
        return redirect()->route('roles.show', $role)->with('role', $role);
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
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      return redirect()->back();
    }

    $role = Role::with('permissions')->where('id', $id)->first();

    if (isset($role)) {
      return view('pages.roles.view')
        ->with('role', $role);
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
      'roles' => 'required|array'
    ]);

    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      $user = User::find($request->user_id);
      if ($user) $user->roles()->sync($request->roles);
    }
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
      'permissions' => 'required|array',
      'role_id' => 'required|min:1'
    ]);

    // validate inputs
    if ($validator->fails()) {
      return redirect()->back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    } else {
      $role = Role::find($request->role_id);
      if ($role) {
        $role->permissions()->sync($request->permissions);
      }
    }

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



  public function showPermissionsForm($id)
  {
    if (!Auth::check() && !Auth::user()->hasRole(['super_admin', 'admin'])) {
      toast('error', 'Unauthorized action!');
      return redirect()->back();
    }

    $role = Role::where('id', $id)->with('permissions')->first();
    $permissions = Permission::all();

    return view('pages.roles.permissions_form')
      ->with('permissions', $permissions)
      ->with('role', $role);
  }
}
