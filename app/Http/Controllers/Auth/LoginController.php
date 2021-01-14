<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  // protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  
  public function showLoginForm()
  {
    if (!Auth::check()) {
      session(['link' => url()->previous()]);
      return view('auth.login');
    } else {
      return url()->previous();
    }
  }

  protected function redirectTo()
  {
    return url()->previous() ? url()->previous() : RouteServiceProvider::HOME;
  }

  protected function authenticated(Request $request, $user)
  {
    if (url()->previous() !== '') {
      return redirect(url()->previous());
    } else {
      return route('dashboard');
    }
  }



  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function register(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'name' => ['required', 'string', 'min:5', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
      'role' => ['required', 'string', 'min:3']
    ]);

    if ($validator->fails()) {
      return back()
        ->withErrors($validator->errors())
        ->withInput($request->all());
    }

    try {
      $user = [];

      $user['name'] = $request['name'];
      $user['email'] = $request['email'];
      $user['password'] = Hash::make($request['password']);

      $user_data = User::create($user);

      // Attach default role if role was not specified
      if (!isset($request['role'])) $request['role'] = 'user';
      $client_role = $request['role'] ? Role::where('name', $request['role'])->first() : Role::where('name', 'user')->first();
      if ($client_role) {
        $user_data->roles()->attach($client_role->id);
      }

      $this->guard()->login($user_data);

      return $this->registered($request, $user_data) ?: redirect($this->redirectPath());
    } catch (\Throwable $th) {
      Session::flash('error', 'Registration failed!');
      return redirect()->back();
    }
  }
}
