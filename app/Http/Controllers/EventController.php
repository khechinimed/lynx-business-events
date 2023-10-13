<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventsDateRangeRequest;
use App\Http\Requests\EventsRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return response()->json(['events' => $events], 200);
    }

    public function getEventsByDateRange(EventsDateRangeRequest $request)
    {
        $clientTimezone = 'Europe/Paris';

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $events = Event::inDateRange($startDate, $endDate, $clientTimezone)->get();

        return response()->json(['events' => $events], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventsRequest $request)
    {
        $event = Event::create($request->all());

        return response()->json(['event' => $event], 201);
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     $event = Event::findOrFail($id);

    //     return response()->json(['event' => $event], 200);
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventsRequest $request, string $id)
    {
        $event = Event::findOrFail($id);

        $event->update($request->all());

        return response()->json(['event' => $event], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
}