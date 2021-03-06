<?php

use Illuminate\Http\Request;

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

Route::post( 'auth/login', 'AuthController@login' );
Route::get( 'auth/logout', 'AuthController@logout' );

Route::middleware( [ 'jwt.auth' ] )->group( function () {
	Route::resource( 'users', 'UserController' )->only( [ 'index', 'show', 'store', 'update' ] );
	Route::resource( 'bikes', 'BikeController' )->only( [ 'index', 'show', 'store', 'update' ] );
	Route::resource( 'accessories', 'AccessoryController' )->only( [ 'index', 'show', 'store', 'update' ] );
	Route::resource( 'statuses', 'StatusController' )->only( [ 'index' ] );
} );
