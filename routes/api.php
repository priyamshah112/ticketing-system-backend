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
    Route::post("/reset-password",[App\Http\Controllers\APIs\AuthController::class, 'reset_password']);
    Route::post('/forgot-password', [App\Http\Controllers\APIs\AuthController::class, 'forgot_password']);

    // Exports
    Route::get("/software/export", [App\Http\Controllers\APIs\SoftwareController::class, 'export']);

    Route::get('/countries', [App\Http\Controllers\APIs\HomeController::class, 'countries']);

});

Route::group(['middleware' => 'auth:api','prefix' => 'v1'], function(){
    Route::group(['middleware' => 'role:admin'], function(){
        // Invetory Category
        Route::get('/categories', [App\Http\Controllers\APIs\CategoryController::class, 'index']);
        
        //Inventory
        Route::get("/inventory-summary",[App\Http\Controllers\APIs\InventoryController::class, 'inventorySummary']);
        Route::get("/inventory",[App\Http\Controllers\APIs\InventoryController::class, 'index']);
        Route::post("/inventory",[App\Http\Controllers\APIs\InventoryController::class, 'add']);
        Route::post("/inventory/{id}",[App\Http\Controllers\APIs\InventoryController::class, 'update']);
        Route::delete("/inventory/{id}",[App\Http\Controllers\APIs\InventoryController::class, 'distroy']);
        Route::post("/inventory/import",[App\Http\Controllers\APIs\InventoryController::class, 'import']);
    });

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
    Route::post("/user/import",[App\Http\Controllers\APIs\UserController::class, 'import']);
    Route::get("/user/getlist",[App\Http\Controllers\APIs\UserController::class, 'getlist']);
    Route::get("/support-users",[App\Http\Controllers\APIs\UserController::class, 'getSupportUsers']);

    //Tickets
    Route::get("/tickets",[App\Http\Controllers\APIs\TicketController::class, 'index']);
    Route::post("/ticket/add",[App\Http\Controllers\APIs\TicketController::class, 'add']);
    Route::post("/ticket/status/close",[App\Http\Controllers\APIs\TicketController::class, 'closeTicket']);
    Route::post("/ticket/status/reopen",[App\Http\Controllers\APIs\TicketController::class, 'reopenTicket']);
    Route::post("/ticket/reply",[App\Http\Controllers\APIs\TicketController::class, 'reply']);
    Route::post("/ticket/assign",[App\Http\Controllers\APIs\TicketController::class, 'assignedTicket']);

    Route::get("/faqs",[App\Http\Controllers\APIs\FAQsController::class, 'index']);
    Route::get("/dashboard/faqs",[App\Http\Controllers\APIs\FAQsController::class, 'dashboard']);
    Route::post("/faq/add",[App\Http\Controllers\APIs\FAQsController::class, 'add']);
    Route::post("/faq/delete",[App\Http\Controllers\APIs\FAQsController::class, 'destroy']);

    Route::get("/UI",[App\Http\Controllers\APIs\UIController::class, 'index']);
    Route::get("/dashboard/UI",[App\Http\Controllers\APIs\UIController::class, 'dashboard']);
    Route::post("/UI/add",[App\Http\Controllers\APIs\UIController::class, 'add']);
    Route::post("/UI/delete",[App\Http\Controllers\APIs\UIController::class, 'destroy']);

    Route::get('user-details', [ProfileController::class, 'viewProfile']);
    Route::post('/profile/update', [ProfileController::class, 'updateProfile']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/ticket/add",[App\Http\Controllers\APIs\TicketController::class, 'add']);
