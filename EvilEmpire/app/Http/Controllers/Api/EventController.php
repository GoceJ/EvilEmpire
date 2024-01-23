<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Event;
use App\Helpers\APIHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventCollection;

// Calendar events API - TOUCH NOTHING HERE unless u need to change something and u really know what you are doing otherwise DONT EVEN THINK ABOUT IT!
class EventController extends Controller
{
    // Get all events
    // http://127.0.0.1:8000/api/events
    public function index()
    {
       $events = Event::with('event_type')->get(); 
       return new EventCollection($events);
    }

    // Get specific event by month or month and year
    // http://127.0.0.1:8000/api/events/by-month?month=04
    // http://127.0.0.1:8000/api/events/by-month?month=4&year=2022
    public function getEventsByMonth(Request $request) 
    {
        $month = $request->query("month");
        $year = $request->query("year");
        try {
            if (isset($month)) {
                if(!isset($year)) {
                    $year = Carbon::now()->year; 
                }
                $startOfMonth = Carbon::createFromFormat('Y-m', "$year-$month")->firstOfMonth();
                $endOfMonth = Carbon::createFromFormat('Y-m', "$year-$month")->endOfMonth();
                $events = Event::whereBetween("start_date", [$startOfMonth, $endOfMonth])
                                //->orWhereBetween("end_date", [$startOfMonth, $endOfMonth])
                                ->with("event_type")->get();
                $events->transform(function ($event) {
                    $event->start_date = strtotime($event->start_date);
                    //$event->end_date = strtotime($event->end_date);
                
                    return $event;
                });                         
                return new EventCollection($events);
            } else {
                $response = APIHelpers::createApiResponse(true, 400, 'Please use a valid month and year query parameter.', null);
                return response()->json($response, 400);
            }
        } catch (Exception $e) {
            $response = APIHelpers::createApiResponse(true, 400, 'Please use a valid month and year query parameter.', null);
            return response()->json($response, 400); 
        }

        $events = Event::with('event_type')
            //->where('end_date', '>', Carbon::now()->subDays('61'))
            ->get();
        return response()->json($events, 200);
    }
}
