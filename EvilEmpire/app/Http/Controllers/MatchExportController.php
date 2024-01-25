<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MatchExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.matchExport.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    public function storeTeam(Request $request)
    {
        $new = [];
        $oldData = file_get_contents(__DIR__ . '../../../../database/data/teams.json');
        $users = ($request->getContent());
        
        $new = (!empty($oldData) ?  $oldData . ',' : '' ) . $users;
        file_put_contents(__DIR__ . '../../../../database/data/teams.json', $new . PHP_EOL);
                
        echo json_encode(['200' => 'teamSaved']);
    }

    public function storePlayer(Request $request)
    {
        $new = [];
        $oldData = file_get_contents(__DIR__ . '../../../../database/data/players.json');
        $users = ($request->getContent());
        
        $new = (!empty($oldData) ?  $oldData . ',' : '' ) . $users;
        file_put_contents(__DIR__ . '../../../../database/data/players.json', $new . PHP_EOL);
                
        echo json_encode(['200' => 'playerSaved']);
    }

    public function storeError(Request $request)
    {
        file_put_contents(__DIR__ . '../../../../database/data/logs/dataExtractError.txt', $request->getContent() . PHP_EOL, FILE_APPEND);
                
        echo json_encode(['200' => 'Basketball Error Saved']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
