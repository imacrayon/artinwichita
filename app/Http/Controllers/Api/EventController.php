<?php

namespace App\Http\Controllers\Api;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{
    public function index(Request $request)
    {
        return Event::filter($request)
                ->orderBy('start_time', 'asc')
                ->get();
    }

    public function store(StoreEventRequest $request)
    {
        return Event::create($request->validated());
    }

    public function update(UpdateEventRequest $request)
    {
        return Event::orderBy('start_time', 'asc')->get();
    }
}
