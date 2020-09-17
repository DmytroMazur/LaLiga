<?php

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

Route::post('create-team', 'Api\TeamsController@store');
Route::get('get-team/{id}', 'Api\TeamsController@show');
Route::put('update-team/{id}', 'Api\TeamsController@update');
Route::delete('delete-team/{id}', 'Api\TeamsController@destroy');


Route::post('create-player', 'Api\PlayersController@store');
Route::get('get-player/{id}', 'Api\PlayersController@show');
Route::put('update-player/{id}', 'Api\PlayersController@update');
Route::delete('delete-player/{id}', 'Api\PlayersController@destroy');
Route::get('get-players-team/{id}', 'Api\PlayersController@getTeamPlayers');
Route::get('get-players-position/{position}', 'Api\PlayersController@getPlayersPosition');
Route::get('get-players/{team_id}/{position}', 'Api\PlayersController@getPlayers');


