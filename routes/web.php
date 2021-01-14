<?php

use App\Models\User;
use App\Notifications\VerificationComplete;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes(['verify' => true]);

Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



// Route::group(['middleware' => 'auth'], function () {

// Route::get('/index', function () {
//   return view('pages.index');
// });

// Route::get('/', function () {
//   return view('pages.index');
// })->name('dashboard');

// Route::get('/timetables', function () {
//   return view('pages.timetable.index');
// })->name('timetables');

// Route::get('/timetables/{id}', function () {
//   return view('pages.timetable.view');
// })->name('view-timetable');

// Route::get('/lessons', function () {
//   return view('pages.lesson.index');
// })->name('lessons');

Route::get('testemail', function () {
  Mail::to(['tom@myspace.com'])->send(new Hello);
});
Route::get('/markAsRead', function () {

  auth()->user()->unreadNotifications->markAsRead();

  return redirect()->back();
})->name('mark');

Route::get('/notify', function () {

  $user = Auth::user();

  $details = [
    'greeting' => 'Hi ' . $user->name . ',',
    'body' => 'This is our example notification tutorial',
    'thanks' => 'Thank you for visiting ' . config('app.name') . ' !',
  ];

  try {
    $user->notify(new VerificationComplete($details));

    Session::flash('success', 'Notification successful!');
    return redirect()->back();
  } catch (\Throwable $th) {
    
    Session::flash('error', $th->getMessage());
    return redirect()->back();
  }
  return dd("Done");
});

Route::get('verify', function () {
  return view('auth.verify');
});


// Dashboard
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


// Timetable
Route::resource('timetables', App\Http\Controllers\TimetableController::class);

// School
Route::resource('schools', App\Http\Controllers\SchoolController::class);
Route::get('/activate_school/{id}', [App\Http\Controllers\SchoolController::class, 'setActiveSchool'])->name('activate_school');

// Class
Route::resource('classes', App\Http\Controllers\SchoolClassController::class);

// Lesson
Route::resource('lessons', App\Http\Controllers\LessonController::class);

// Course
Route::resource('courses', App\Http\Controllers\CourseController::class);

// Subscription
Route::resource('subscriptions', App\Http\Controllers\UserTimetableSubscriptionController::class);

// Roles
Route::resource('roles', App\Http\Controllers\RoleController::class);
Route::get('role_permissions/{id}', [App\Http\Controllers\RoleController::class, 'showPermissionsForm'])->name('role_permissions');
Route::post('assign_user_role', [App\Http\Controllers\RoleController::class, 'assignUserRole'])->name('assign_user_role');
Route::post('remove_user_role', [App\Http\Controllers\RoleController::class, 'removeUserRole'])->name('remove_user_role');
Route::post('assign_role_permission', [App\Http\Controllers\RoleController::class, 'assignRolePermission'])->name('assign_role_permission');
Route::post('remove_role_permission', [App\Http\Controllers\RoleController::class, 'removeRolePermission'])->name('remove_role_permission');


// // Users
Route::resource('users', App\Http\Controllers\UserController::class);


// // Notifications
Route::resource('notifications', App\Http\Controllers\NotificationController::class);
Route::get('notifications/toggle_read/{id}', [App\Http\Controllers\NotificationController::class, 'toggleRead'])->name('notifications.toggle_read');
Route::get('notifications/toggle_spam/{id}', [App\Http\Controllers\NotificationController::class, 'toggleSpam'])->name('notifications.toggle_spam');
Route::get('notifications/delete/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.delete');
Route::delete('notifications/delete_all', [App\Http\Controllers\NotificationController::class, 'destroyAll'])->name('notifications.delete_all');

  // });
