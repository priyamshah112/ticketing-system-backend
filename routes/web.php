<?php

use Faker\Factory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get("/export/inventory", [App\Http\Controllers\ExportController::class, 'exportInventory'])->name('exportInventory');
Route::get("/export/users", [App\Http\Controllers\ExportController::class, 'exportUsers'])->name('exportUsers');
Route::get("/export/software", [App\Http\Controllers\ExportController::class, 'exportSoftware'])->name('exportSoftware');
Route::get("/import/sample/user", [App\Http\Controllers\ExportController::class, 'exportUserSample'])->name('exportUserSample');
Route::get("/import/sample/software", [App\Http\Controllers\ExportController::class, 'exportSoftwareSample'])->name('exportSoftwareSample');
Route::get("/import/sample/hardware", [App\Http\Controllers\ExportController::class, 'exportHardwareSample'])->name('exportHardwareSample');
Route::get("/import/sample/faq", [App\Http\Controllers\ExportController::class, 'exportFaqSample'])->name('exportFaqSample');
Route::get("/download/importedExcel/{file}", [App\Http\Controllers\ExportController::class, 'downloadErrorExcel'])->name('downloadErrorExcel');

Route::get('/artisan/clear', function () { 
    Artisan::call('storage:link');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
});

Route::get('/artisan/migrate', function () {
    Artisan::call('migrate');
    Artisan::call('key:generate');
    Artisan::call('db:seed');
});

Route::get('/auth/redirect', function () {

//     $abstractUser = Mockery::mock('Laravel\Socialite\Two\User');
//     $abstractUser->shouldReceive('getId')
//    ->andReturn(rand())
//    ->shouldReceive('getName')
//    ->andReturn('utioghreduik')
//    ->shouldReceive('getEmail')
//    ->andReturn('zeemzach@gmail.com')
//    ->shouldReceive('getAvatar')
//    ->andReturn('https://en.gravatar.com/userimage');

//    $provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
//     $provider->shouldReceive('user')->andReturn($abstractUser);

//     Socialite::shouldReceive('driver->user')->andReturn($provider);

    // After Oauth redirect back to the route
    // $this->visit('/auth/callback')
    // See the page that the user login into
    // ->seePageIs('/');
    return Socialite::driver('github')->redirect();
});
 
Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    // OAuth 2.0 providers...
    // $token = $user->token;
    // $refreshToken = $user->refreshToken;
    // $expiresIn = $user->expiresIn;

    // // OAuth 1.0 providers...
    // $token = $user->token;
    // $tokenSecret = $user->tokenSecret;

    // All providers...
    // $user->getId();
    // $user->getName();
    // $user->getEmail();
    // $user->getAvatar();
    return $user->getName();
});
