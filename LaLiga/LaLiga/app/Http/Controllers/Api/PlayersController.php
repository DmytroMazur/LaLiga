<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StorePlayer;
use App\Http\Requests\UpdatePlayer;
use App\Http\Requests\RoutePosition;
use App\Players;

class PlayersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePlayer $request)
    {
        $input = $request->all();
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError('Validation Error.', $request->validator->messages());
        }
        $player = Players::create($input);
        return $this->sendResponse($player->toArray(), 'Player created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $player = Players::find($id);
        if (is_null($player)) return $this->sendError('Player not found.');
        
        $this->convertEurtoUsd($player);      
        
        return $this->sendResponse($player->toArray(), 'Player retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePlayer $request, $id)
    {
        $input = $request->all();
        
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError('Validation Error.', $request->validator->messages());
        }
        
        $player = Players::find($id);

        if(is_null($player)) return $this->sendError('Player not found.');

        foreach($input as $key=>$value){
            $player->$key = $value;
        }

        $player->save();

        return $this->sendResponse($player->toArray(), 'Player updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $player = Players::find($id);
        
        if(is_null($player)) return $this->sendError('Player not found.');
        
        $player->delete();
        
        return $this->sendResponse($player->toArray(), 'Player deleted successfully.');
    }

    /**
     * Get all players.
     *
     * @param  int  $teamId
     * @return \Illuminate\Http\Response
     */
    public function getTeamPlayers($teamId){
        $players = Players::with('teams')->where('team_id', $teamId)->get(); 

        if(count($players) == 0) return $this->sendError('Players not found.');

        foreach($players as $key => $player){
            $this->convertEurtoUsd($players[$key]);
        }

        return $this->sendResponse($players->toArray(), 'Players retrieved successfully.');
     
    }

    /**
     * Get players position.
     *
     * @param  string  $position
     * @return \Illuminate\Http\Response
     */
    public function getPlayersPosition(RoutePosition $request,$position){

        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError('Validation Error.', $request->validator->messages());
        }

        $players = Players::where('position', $position)->get(); 
        
        foreach($players as $key => $player){
            $this->convertEurtoUsd($players[$key]);
        }

        return $this->sendResponse($players->toArray(), 'Players retrieved successfully.');
     
    }

    /**
     * Get players.
     *
     * @param  string  $position
     * @param  int  $teamId
     * @return \Illuminate\Http\Response
     */
    public function getPlayers(RoutePosition $request ,$teamId, $position){
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError('Validation Error.', $request->validator->messages());
        }

        $players = Players::with('teams')->where('team_id', $teamId)->where('position', $position)->get();
        
        if(count($players) == 0 ) return $this->sendError('Players not found.');

        foreach($players as $key => $player){
            $this->convertEurtoUsd($players[$key]);
        }
        
        return $this->sendResponse($players->toArray(), 'Players retrieved successfully.');
    }

    /**
     * Convert Eur to Usd
     *
     * @return \Illuminate\Http\Response
     */
    private function convertEurtoUsd($player){
        $usdValue = $this->connectApi();
        $player->price = $player->price*$usdValue;
    }   

    /**
     * Connect to Api
     *
     * @return \Illuminate\Http\Response
     */
    private function connectApi(){
        $curl = curl_init();        
        curl_setopt($curl, CURLOPT_URL, "https://api.exchangeratesapi.io/latest?symbols=USD");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return json_decode($output)->rates->USD;
    }
}
