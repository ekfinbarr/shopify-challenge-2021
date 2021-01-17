<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
// use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

  use RegistersUsers;

  /**
   * Where to redirect users after registration.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest');
  }

  /**
   * Show the application registration form.
   *
   * @return \Illuminate\View\View
   */
  public function showRegistrationForm()
  {
    $roles = Role::all();
    return view('auth.register')->with('roles', $roles);
  }


  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
    return Validator::make($data, [
      'name' => ['required', 'string', 'max:255'],
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'phone' => ['nullable', 'string', 'unique:users', 'max:15'],
      // 'country' => ['nullable', 'string', 'min:2'],
      'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Models\User
   */
  protected function create(array $data)
  {
    return User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'country' => isset($data['country'])?$data['country']:'Nigeria',
      'phone' => $data['phone'],
      'last_login_at' => Carbon::now(),
      'password' => Hash::make($data['password']),
    ]);
  }

  /**
   * Handle a registration request for the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
   */
  public function register(Request $request)
  {
    $this->validator($request->all())->validate();

    event(new Registered($user = $this->create($request->all())));

    // Attach role
    if (!isset($request->type)) $request->type = 'user';
    $user_role = $request->type ? Role::where('name', $request->type)->first() : Role::where('name', 'user')->first();
    if ($user_role) {
      $user->roles()->attach($user_role->id);
    }

    $this->guard()->login($user);

    session()->flash('success', '<b>Hi ' . $user->name . '!</b> Thanks for signing up!');

    if ($response = $this->registered($request, $user)) {
      return $response;
    }

    return $request->wantsJson()
      ? new JsonResponse([], 201)
      : redirect($this->redirectPath());
  }
}
