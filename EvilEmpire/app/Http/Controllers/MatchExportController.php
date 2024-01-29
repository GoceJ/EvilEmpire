<?php

namespace App\Http\Controllers;

use App\Models\Ajaxfail;
use App\Models\TimeStamp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class MatchExportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = TimeStamp::orderBy('id', 'desc')->take(10)->get();
        return view('pages.matchExport.index', ['time_stamp_data' => $data, 'date' => isset($data[0]->time_stamp) ? $data[0]->time_stamp : false]);
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

    // Basketball Teams data storage and seed
    public function storeBasketballTeam(Request $request)
    {
        $new = [];
        $oldData = file_get_contents(__DIR__ . '../../../../database/data/basketball_teams.json');
        $data = ($request->getContent());
        
        $new = (strlen($oldData) > 1 ?  $oldData . ',' : '' ) . $data;
        file_put_contents(__DIR__ . '../../../../database/data/basketball_teams.json', $new . PHP_EOL);
                
        $timeStampData = $this->updateTimeStamp($data, 'basket_import', true);
        Artisan::call('db:seed',['--class' => 'BasketballTeamsTableSeeder']);

        echo json_encode(['200' => 'Basketball Team Saved', 'data' => $timeStampData]);
    }

    // Basket Player data storage and seed
    public function storeBasketballPlayer(Request $request)
    {
        $new = [];
        $oldData = file_get_contents(__DIR__ . '../../../../database/data/basketball_players.json');
        $data = ($request->getContent());
        
        $new = (strlen($oldData) > 1 ?  $oldData . ',' : '' ) . $data;
        file_put_contents(__DIR__ . '../../../../database/data/basketball_players.json', $new);

        if (strlen($new) > 0) {
            $timeStampData = $this->updateTimeStamp($data, 'player_import', true);
            Artisan::call('db:seed',['--class' => 'BasketballPlayersTableSeeder']);
            
            echo json_encode(['200' => 'Basketball Player Saved', 'data' => $timeStampData]);
        } else {
            echo json_encode(['200' => 'Basketball Player Saved', 'data' => TimeStamp::orderBy('id','DESC')->first()]);
        }
    }

    public function storeFootballTeam(Request $request)
    {
        $new = [];
        $oldData = file_get_contents(__DIR__ . '../../../../database/data/football_teams.json');
        $data = ($request->getContent());
        
        $new = (strlen($oldData) > 1 ?  $oldData . ',' : '' ) . $data;
        file_put_contents(__DIR__ . '../../../../database/data/football_teams.json', $new . PHP_EOL);
                
        $timeStampData = $this->updateTimeStamp($data, 'football_import', true);

        Artisan::call('db:seed',['--class' => 'FootballTableSeeder']);
        
        echo json_encode(['200' => 'Football Team Saved', 'data' => $timeStampData]);
    }

    public function updateTimeStamp($data, $column, $message, $directDate = false) {
        if (!$directDate) {
            $match = explode('match_date', $data);
            $comma = explode(',', $match[1]);
            $replace = str_replace('"', '', $comma[0]);
            $date = str_replace(':', '', $replace);
        } else {
            $date = $data;
        }

        $timestamp = TimeStamp::where('time_stamp', $date);
        if ($timestamp->exists()) {
            $timestampId = $timestamp->first()->id;
        } else {
            $timestampId = TimeStamp::insertGetId([
                'time_stamp' => $date
            ]);
        }

        TimeStamp::whereId($timestampId)->update([$column => $message]);
        $timestamp = TimeStamp::where('id', $timestampId)->get();
        return $timestamp[0];
    }

    public function storeError(Request $request)
    {
        file_put_contents(__DIR__ . '../../../../database/data/logs/dataExtractError.txt', $request->getContent() . PHP_EOL, FILE_APPEND);
        $json = json_decode($request->getContent());
        
        if ($json->sport == 'basketball') {
            $timeStampData = $this->updateTimeStamp($json->data_date, 'basket_error', true, true);
        } else if ($json->sport == 'football') {
            $timeStampData = $this->updateTimeStamp($json->data_date, 'football_error', true, true);
        }

        echo json_encode(['200' => $json->data_date, 'data' => $timeStampData]);
    }

    public function ajaxErrorDescription(Request $request)
    {
        Ajaxfail::insert(['description' => $request->getContent()]);
        // $str = '[' . $request->getContent() . ']';
        // $decode = json_decode($str);
        // $text = $decode;
        echo json_encode(['200' => 'Ajax error saved']);
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
