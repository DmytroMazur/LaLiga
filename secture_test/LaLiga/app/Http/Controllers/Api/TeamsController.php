<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTeam;
use App\Http\Controllers\Api\BaseController;
use App\Teams;

class TeamsController extends BaseController
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
    public function store(StoreTeam $request)
    {
        $input = $request->all();
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError('Validation Error.', $request->validator->messages());
        }
        $team = Teams::create($input);
        return $this->sendResponse($team->toArray(), 'Team created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = Teams::find($id);
        if (is_null($team)) return $this->sendError('Team not found.');
        
        return $this->sendResponse($team->toArray(), 'Team retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTeam $request, $id)
    {
        $input = $request->all();
        
        if (isset($request->validator) && $request->validator->fails()) {
            return $this->sendError('Validation Error.', $request->validator->messages());
        }
        
        $team = Teams::find($id);

        if(is_null($team)) return $this->sendError('Team not found.');

        $team->team_name = $input['team_name'];
        $team->save();

        return $this->sendResponse($team->toArray(), 'Team updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $team = Teams::find($id);
        
        if(is_null($team)) return $this->sendError('Team not found.');
        
        $team->delete();
        
        return $this->sendResponse($team->toArray(), 'Team deleted successfully.');
    }

    
}
