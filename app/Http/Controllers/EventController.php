<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EventsDateRangeRequest;
use App\Http\Requests\EventsRequest;
use Carbon\Carbon;
use DateTimeZone;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $events = Event::all();
        return response()->json(['events' => $events], 200);
    }

    public function getEventsByDateRange(EventsDateRangeRequest $request)
    {
        // Définir le fuseau horaire français
        $clientTimezone = new DateTimeZone('Europe/Paris');
    
        $startDate = Carbon::parse($request->input('start_date'), $clientTimezone)->endOfDay();
        $endDate = Carbon::parse($request->input('end_date'), $clientTimezone)->endOfDay();
    
        $events = Event::inDateRange($startDate->toDateTimeString(), $endDate->toDateTimeString())->get();
    
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
    public function show(string $id)
    {
        //
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        return response()->json(['event' => $event], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventsRequest $request, string $id)
    {
    
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $event->update($request->all());

        return response()->json(['event' => $event], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
}