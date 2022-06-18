<?php

use App\Http\Controllers\APIs\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['prefix' => 'v1'], function(){
    Route::get('/', function(){
        return "Welcome To Ticketing System Api Library";
    });
    Route::post("/login",[App\Http\Controllers\APIs\AuthController::class, 'login']);
    Route::post("/reset",[App\Http\Controllers\APIs\AuthController::class, 'reset']);
    Route::post('/forgot-password', [App\Http\Controllers\APIs\AuthController::class, 'forgot_password']);

    // Exports
    Route::get("/software/export", [App\Http\Controllers\APIs\SoftwareController::class, 'export']);

    Route::get('/countries', [App\Http\Controllers\APIs\HomeController::class, 'countries']);

});

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1'], function(){
    //Roles
    Route::post('/change-password', [App\Http\Controllers\APIs\UserController::class, 'changePassword']);

    Route::get('/request-by-user', [App\Http\Controllers\APIs\HomeController::class, 'requestByUser']);
    Route::get('/hardware-inventory', [App\Http\Controllers\APIs\HomeController::class, 'hardwareInventory']);
    Route::get('/track-by-contry', [App\Http\Controllers\APIs\HomeController::class, 'trackByContry']);
    Route::get('/ticket-request', [App\Http\Controllers\APIs\HomeController::class, 'ticketRequest']);
    Route::get('/ticket-priority-level', [App\Http\Controllers\APIs\HomeController::class, 'ticketPriorityLevel']);


    Route::get("/dashboard",[App\Http\Controllers\APIs\UserController::class, 'dashboard']);
    Route::get("/userdashboard",[App\Http\Controllers\APIs\UserController::class, 'userDashboard']);
    Route::get("/roles",[App\Http\Controllers\APIs\RolesController::class, 'index']);
    Route::post("/role/add",[App\Http\Controllers\APIs\RolesController::class, 'add']);
    Route::post("/role/delete",[App\Http\Controllers\APIs\RolesController::class, 'distroy']);

    //Users
    Route::get("/users",[App\Http\Controllers\APIs\UserController::class, 'index']);
    Route::get("/users/employee",[App\Http\Controllers\APIs\UserController::class, 'employee']);
    Route::post("/user/add",[App\Http\Controllers\APIs\UserController::class, 'add']);
    Route::post("/user/delete",[App\Http\Controllers\APIs\UserController::class, 'distroy']);
    Route::post("/user/inventory",[App\Http\Controllers\APIs\UserController::class, 'addInventory']);
    Route::post("/user/inventory/remove",[App\Http\Controllers\APIs\UserController::class, 'removeInventory']);
    Route::post("/user/get/inventory",[App\Http\Controllers\APIs\UserController::class, 'availableInventories']);
    Route::post("/user/create/submit",[App\Http\Controllers\APIs\UserController::class, 'createUserDetails']);
    Route::get("/user/getlist",[App\Http\Controllers\APIs\UserController::class, 'getlist']);
    Route::get("/support-users",[App\Http\Controllers\APIs\UserController::class, 'getSupportUsers']);

    //Tickets
    Route::get("/tickets",[App\Http\Controllers\APIs\TicketController::class, 'index']);
    Route::post("/ticket/add",[App\Http\Controllers\APIs\TicketController::class, 'add']);
    Route::post("/ticket/status/close",[App\Http\Controllers\APIs\TicketController::class, 'closeTicket']);
    Route::post("/ticket/reply",[App\Http\Controllers\APIs\TicketController::class, 'reply']);
    Route::post("/ticket/assign",[App\Http\Controllers\APIs\TicketController::class, 'assignedTicket']);


    //Hardware Inventory
    Route::get("/inventory/{type}",[App\Http\Controllers\APIs\InventoryController::class, 'index']);
    Route::post("/inventory/{type}/add",[App\Http\Controllers\APIs\InventoryController::class, 'add']);
    Route::post("/inventory/delete",[App\Http\Controllers\APIs\InventoryController::class, 'distroy']);
    Route::post("/inventory/import",[App\Http\Controllers\APIs\InventoryController::class, 'import']);
    //Route::post("/ticket/reply",[App\Http\Controllers\APIs\TicketController::class, 'reply']);

    //Software Inventory
    Route::get("/software/inventory",[App\Http\Controllers\APIs\SoftwareController::class, 'index']);
    Route::post("/software/inventory/add",[App\Http\Controllers\APIs\SoftwareController::class, 'add']);
    Route::post("/software/inventory/delete",[App\Http\Controllers\APIs\SoftwareController::class, 'distroy']);
    Route::post("/software/inventory/import",[App\Http\Controllers\APIs\SoftwareController::class, 'import']);

    Route::get("/faqs",[App\Http\Controllers\APIs\FAQsController::class, 'index']);
    Route::post("/faq/add",[App\Http\Controllers\APIs\FAQsController::class, 'add']);
    Route::post("/faq/delete",[App\Http\Controllers\APIs\FAQsController::class, 'distroy']);

    Route::post('view-profile', [ProfileController::class, 'viewProfile']);
    Route::post('update-profile', [ProfileController::class, 'updateProfile']);



});

Route::post("/user/import",[App\Http\Controllers\APIs\UserController::class, 'import']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/ticket/add",[App\Http\Controllers\APIs\TicketController::class, 'add']);
