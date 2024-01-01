<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use Illuminate\Http\Request;
use App\Http\Resources\CalendarResource;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends Controller
{

    public function index()
    {
        return CalendarResource::collection(Calendar::all());
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $new_calendar = Calendar::create($request->all());
        return response()->json([
            'data' => new CalendarResource($new_calendar),
            'message' => 'Successfully added new event!',
            'status' => Response::HTTP_CREATED
        ]);
    }


    public function show(Calendar $calendar)
    {
        return response($calendar, Response::HTTP_OK);
    }


    public function edit(Calendar $calendar)
    {
        //
    }


    public function update(Request $request, Calendar $calendar): \Illuminate\Http\JsonResponse
    {
        $calendar->update($request->all());
        return response()->json([
            'data' => new CalendarResource($calendar),
            'message' => 'Successfully updated event!',
            'status' => Response::HTTP_ACCEPTED
        ]);
    }

    public function destroy(Calendar $calendar)
    {
        $calendar->delete();
        return response('Event removed successfully!', Response::HTTP_NO_CONTENT);
    }
}
