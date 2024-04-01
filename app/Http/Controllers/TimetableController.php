<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use App\Http\Requests\StoreTimetableRequest;
use App\Http\Requests\UpdateTimetableRequest;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;


class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::get();
        return view('timetable',compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTimetableRequest $request)
    {
        $event = Event::create([
            'name' => $request->title,
            'description' => $request->description,
            'startDateTime' => Carbon::parse($request->current_date . ' ' . $request->startDateTime),
            'endDateTime' => Carbon::parse($request->current_date . ' ' . $request->endDateTime),
            'timeZone' => 'Asia/Baku',
        ]);

        return response()->json($event, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Timetable $timetable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timetable $timetable)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTimetableRequest $request)
    {
        $event = Event::find(\request()->segment(2));
        if (request()->has('action')) {
            $event->update([
                'startDateTime' => Carbon::parse($request->updateStartDateTime),
                'endDateTime' => Carbon::parse($request->updateEndDateTime),
                'timeZone' => 'Asia/Baku',
            ]);
        } else {
            $event->update([
                'name' => $request->update_title,
                'description' => $request->updateDescription,
                'startDateTime' => Carbon::parse($request->current_date . ' ' . $request->updateStartDateTime),
                'endDateTime' => Carbon::parse($request->current_date . ' ' . $request->updateEndDateTime),
                'timeZone' => 'Asia/Baku',
            ]);
        }

        return response()->json($event, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Event::find(\request()->segment(2))->delete();

        return response()->json([
            'message' => 'The event deleted successfully'
        ], 200);
    }
}
