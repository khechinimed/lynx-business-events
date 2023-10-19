<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Http\Requests\EventsDateRangeRequest;
use App\Http\Requests\EventsRequest;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('Views/OurEvents', [
            'allEvents' => Event::all() ?? []
        ]);
    }

    public function calendar(): Response
    {
        return Inertia::render('Views/OurCalendar', [
            'allEvents' => Event::all() ?? []
        ]);
    }

    public function management(): Response
    {
        return Inertia::render('Views/EventManagement', [
            'allEvents' => Event::all() ?? []
        ]);
    }

    public function getEventsByDateRange(EventsDateRangeRequest $request): Response
    {
        $clientTimezone = 'Europe/Paris';

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $events = Event::inDateRange($startDate, $endDate, $clientTimezone)->get();
        return Inertia::render('Views/EventManagement', [
            'allEvents' => $events ?? []
        ]);
    }

    public function store(EventsRequest $request): Response
    {
        Event::create($request->all());
        return Inertia::render('Views/OurEvents', [
            'allEvents' => Event::all() ?? []
        ]);
    }

    public function update(EventsRequest $request, string $id): Response
    {
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return Inertia::render('Views/OurEvents', [
            'allEvents' => Event::all() ?? []
        ]);
    }

    public function destroy(string $id): Response
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return Inertia::render('Views/OurEvents', [
            'allEvents' => Event::all() ?? []
        ]);
    }
}
