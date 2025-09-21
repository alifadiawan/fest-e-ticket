<?php

use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\TokenController;
use App\Http\Controllers\Tokens\GenerateTokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('Auth.Login');
});

Route::get('/dashboard/overview', function () {
    return view('Dashboard.Overview');
});


/************
*   Events
*************/
Route::get('/events/overview', [EventsController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventsController::class, 'create'])->name('events.create');
Route::post('/events/store', [EventsController::class, 'store'])->name('events.store');
Route::get('/events/show/{id}', [EventsController::class, 'show'])->name('events.show');


/************
*   Tokens
*************/
Route::post('/token/generate/{event_id}', [GenerateTokenController::class, 'generateTokens'])->name('generate.token');


/************
*   Participants
*************/



/************
*
* Tokens
*   
*************/
Route::get('/events/{event_id}/token/{batch_id}', [TokenController::class, 'show'])->name('tokens.show');




/************
*   Testing Registration
*************/
