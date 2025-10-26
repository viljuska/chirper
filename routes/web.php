<?php

use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

//Route::get('/', static function () {
//    return view('home');
//});

Route::get( '/', [ ChirpController::class, 'index' ] );

Route::middleware( 'auth' )->group( static function () {
    Route::post( '/chirps', [ ChirpController::class, 'store' ] );
    Route::get( '/chirps/{chirp}/edit', [ ChirpController::class, 'edit' ] );
    Route::put( '/chirps/{chirp}', [ ChirpController::class, 'update' ] );
    Route::delete( '/chirps/{chirp}', [ ChirpController::class, 'destroy' ] );
} );

Route::view( '/register', 'auth.register' )
    ->middleware( 'guest' )
    ->name( 'register' );

// Registration route
Route::post( '/register', Register::class );

// Logout route
Route::post( '/logout', Logout::class )
    ->middleware( 'auth' )
    ->name( 'logout' );

// Login routes
Route::view( '/login', 'auth.login' )
    ->middleware( 'guest' )
    ->name( 'login' );
Route::post( '/login', Login::class )
    ->middleware( 'guest' );
