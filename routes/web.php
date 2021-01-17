<?php

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



Auth::routes(/*['verify' => true]*/);

Route::get('verify', function () {
  return view('auth.verify');
});


// Dashboard
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'showAboutPage'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'showContactPage'])->name('contact');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


// Media
Route::resource('media', App\Http\Controllers\MediaController::class);

// Category
Route::resource('categories', App\Http\Controllers\CategoryController::class);

// Tag
Route::resource('tags', App\Http\Controllers\TagController::class);

// Media Format
Route::resource('media_formats', App\Http\Controllers\MediaFormatController::class);

// Folders
Route::resource('folders', App\Http\Controllers\FolderController::class);

// Media Type
Route::resource('media_types', App\Http\Controllers\MediaTypeController::class);

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
