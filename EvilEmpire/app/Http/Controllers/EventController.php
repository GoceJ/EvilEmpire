<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Http\Request;
use App\Http\Requests\EventRequest;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        $eventTypes = EventType::all();
        return view('pages.calendar.index', compact('events', 'eventTypes'));
    }

    public function recentEventsJson()
    {
        $events = Event::with('event_type')
            ->get();
        return response()->json($events, 200);
    }

    public function store(EventRequest $request)
    {
        if (!Event::create($request->validated()))
            return response()->json(['status' => 400, 'message' => 'Error',]);

        return response()->json(['status' => 200, 'message' => 'Success',]);
    }

    public function update(EventRequest $request, Event $event)
    {
        if (!$event->update($request->validated()))
            return response()->json(['status' => 400, 'message' => 'Error',]);

        return response()->json(['status' => 200, 'message' => 'Success',]);
    }

    public function destroy(Event $event)
    {
        if (!$event->delete())
            return response()->json(['status' => 400, 'message' => 'Error',]);

        return response()->json(['status' => 200, 'message' => 'Success',]);
    }
}
