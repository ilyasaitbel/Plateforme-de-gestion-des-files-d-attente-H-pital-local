<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CitoyenController;
use App\Http\Controllers\AdminAgentController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Tickets
    |--------------------------------------------------------------------------
    */
    Route::resource('tickets', TicketController::class);
    Route::post('/tickets/{ticket}/cancel', [TicketController::class, 'cancel'])->name('tickets.cancel');

    /*
    |--------------------------------------------------------------------------
    | Queues
    |--------------------------------------------------------------------------
    */
    Route::resource('queues', QueueController::class);
    Route::post('/queues/{queue}/open', [QueueController::class, 'open'])->name('queues.open');
    Route::post('/queues/{queue}/close', [QueueController::class, 'close'])->name('queues.close');
    Route::post('/queues/{queue}/call-next', [QueueController::class, 'callNext'])->name('queues.callNext');

    /*
    |--------------------------------------------------------------------------
    | Citoyen Actions
    |--------------------------------------------------------------------------
    */
    Route::post('/citoyens/{citoyen}/request-ticket', [CitoyenController::class, 'requestTicket'])->name('citoyens.requestTicket');
    Route::post('/citoyens/{citoyen}/tickets/{ticket}/cancel', [CitoyenController::class, 'cancelTicket'])->name('citoyens.cancelTicket');

    /*
    |--------------------------------------------------------------------------
    | Admin Only
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {

        // Core management
        Route::get('/hospitals/create', [HospitalController::class, 'create'])->name('hospitals.create');
        Route::post('/hospitals', [HospitalController::class, 'store'])->name('hospitals.store');
        Route::resource('services', ServiceController::class);
        Route::resource('citoyens', CitoyenController::class);
        Route::resource('agents', AgentController::class);
        Route::resource('users', UserController::class);

        /*
        |--------------------------------------------------------------------------
        | Admin Agents Management
        |--------------------------------------------------------------------------
        */
        Route::get('/admin/agents', [AdminAgentController::class, 'index'])->name('admin.agents.index');
        Route::get('/admin/agents/create', [AdminAgentController::class, 'create'])->name('admin.agents.create');
        Route::post('/admin/agents', [AdminAgentController::class, 'store'])->name('admin.agents.store');
        Route::delete('/admin/agents/{agent}', [AdminAgentController::class, 'destroy'])->name('admin.agents.destroy');

    });

});
