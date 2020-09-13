# LaLiga
1. docker-compose up -d
2. Las rutas:
Ejemplo: localhost:8080/public/api/get-team/4

Route::post('create-team', 'Api\TeamsController@store');
Route::get('get-team/{id}', 'Api\TeamsController@show');
Route::put('update-team/{id}', 'Api\TeamsController@update'); - 
Route::delete('delete-team/{id}', 'Api\TeamsController@destroy');


Route::post('create-player', 'Api\PlayersController@store');
Route::get('get-player/{id}', 'Api\PlayersController@show');
Route::put('update-player/{id}', 'Api\PlayersController@update');
Route::delete('delete-player/{id}', 'Api\PlayersController@destroy');
Route::get('get-players-team/{id}', 'Api\PlayersController@getTeamPlayers');
Route::get('get-players-position/{position}', 'Api\PlayersController@getPlayersPosition');
Route::get('get-players/{team_id}/{position}', 'Api\PlayersController@getPlayers');
