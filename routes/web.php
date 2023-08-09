<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AzureUserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'welcome']);

Route::get('/signin', [AuthController::class,'signin']);
Route::get('/callback', [AuthController::class,'callback']);
Route::get('/signout', [AuthController::class,'signout']);

Route::get('/calendar', [CalendarController::class, 'calendar']);
Route::get('/calendar/new', [CalendarController::class, 'getNewEventForm']);
Route::post('/calendar/new', [CalendarController::class, 'createNewEvent']);
Route::get('/users', [AzureUserController::class, 'getAllUsers'])->name('azureUsers');
Route::get('/import/users', [AzureUserController::class, 'importAllUsers'])->name('importNewAzureUser');


Route::get("/export/inventory", [App\Http\Controllers\ExportController::class, 'exportInventory'])->name('exportInventory');
Route::get("/import/inventory/sample", [App\Http\Controllers\ExportController::class, 'exportHardwareSample'])->name('exportInventorySample');
Route::get("/export/users", [App\Http\Controllers\ExportController::class, 'exportUsers'])->name('exportUsers');
Route::get("/import/sample/user", [App\Http\Controllers\ExportController::class, 'exportUserSample'])->name('exportUserSample');
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


