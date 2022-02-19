<?php

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


