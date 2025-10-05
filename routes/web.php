<?php

use App\Http\Controllers\Admin\EventsController;
use App\Http\Controllers\Admin\TokenController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\OAuth\GoogleController;
use App\Http\Controllers\Auth\OAuth\RegisterController;
use App\Http\Controllers\Tokens\ClaimTokenController;
use App\Http\Controllers\Tokens\GenerateTokenController;
use App\Models\EventModel;
use App\Models\TokenBatchModel;
use App\Models\TokenModel;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('Auth.Login');
});

Route::get('/dashboard/overview', function () {
    $events = EventModel::select('events.*')
    ->selectRaw('COUNT(tokens.id) as total_tokens')
    ->selectRaw('SUM(CASE WHEN tokens.status = "used" THEN 1 ELSE 0 END) as claimed_tokens')
    ->leftJoin('tokens', 'tokens.event_id', '=', 'events.id')
    ->groupBy('events.id')
    ->take(5)
    ->get();

    $totalEvent = EventModel::count();
    $totalTokens = TokenModel::where('status', '=', 'used')->count();
    $totalUsers = User::count();

    return view('Dashboard.Overview', compact('events', 'totalEvent', 'totalTokens', 'totalUsers'));
});


/************
 *   Events
 *************/
Route::get('/events/overview', [EventsController::class, 'index'])->name('events.index');
Route::get('/events/create', [EventsController::class, 'create'])->name('events.create');
Route::post('/events/store', [EventsController::class, 'store'])->name('events.store');
Route::get('/events/show/{id}', [EventsController::class, 'show'])->name('events.show');
Route::get('/events/edit/{id}', [EventsController::class, 'edit'])->name('events.edit');
Route::POST('/events/update/{id}', [EventsController::class, 'update'])->name('events.update');


/************
 *   Tokens
 *************/
Route::post('/token/generate/{event_id}', [GenerateTokenController::class, 'generateTokens'])->name('generate.token');
Route::get('/redeem/{token}', [ClaimTokenController::class, 'view'])->name('tokens.redeem');
Route::get('/redeem/token/success', [ClaimTokenController::class, 'successView'])->name('tokens.success');

/************
 *   OAuth
 *************/
Route::get('/auth/google/', [GoogleController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/auth/google/register', [RegisterController::class, 'showRegistrasionView'])->name('google.register');
Route::post('/auth/google/register', [RegisterController::class, 'storeUserFromGoogle'])->name('google.register.store');


/************
 *   Participants / Users
 *************/
Route::get('/users/all', [UsersController::class, 'index'])->name('user.index');
Route::get('/user/{id}/show', [UsersController::class, 'show'])->name('user.show');
Route::get('/user/{id}/edit', [UsersController::class, 'edit'])->name('user.edit');
Route::get('/user/{id}/update', [UsersController::class, 'update'])->name('user.update');
Route::get('/user/{id}/delete', [UsersController::class, 'delete'])->name('user.delete');



/************
 *
 * Tokens
 *
 *************/
Route::get('/events/{event_id}/token/{batch_id}', [TokenController::class, 'show'])->name('tokens.show');
Route::get('/tokens/{event_id}/{batch_id}/download', [TokenController::class, 'download'])->name('tokens.download');




/************
 *   Testing Registration
 *************/
