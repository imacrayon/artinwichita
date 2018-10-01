<?php

namespace App\Http\Controllers\Api;

use App\Place;
use App\Http\Controllers\Controller;

class PlaceController extends Controller
{
    public function index()
    {
        return response()->json(Place::orderBy('name', 'asc')->get());
    }
}
