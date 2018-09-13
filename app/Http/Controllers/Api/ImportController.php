<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImportController extends Controller
{
    public function __construct(Client $client)
    {
        $this->middleware('auth');
    }

    public function facebook(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $eventId = $this->parseEventIdFromUrl($request->url);

        return $this->fetchFacebookEvent($eventId);
    }

    private function parseEventIdFromUrl($url)
    {
        return array_get(explode('/', parse_url($url, PHP_URL_PATH)), 2);
    }

    private function fetchFacebookEvent($id)
    {
        $response = (new Client())->get("https://graph.facebook.com/{$id}", [
            'headers' => ['Accept' => 'application/json'],
            'query' => ['access_token' => session('facebook_token')]
        ]);

        $data = json_decode($response->getBody(), true);

        $event = new \StdClass;
        $event->name = $data['name'];
        // 2018-09-19T22:20:00-0500
        $event->start_time = $this->toAppTimezone($data['start_time']);
        $event->end_time = isset($data['end_time'])
            ? $this->toAppTimezone($data['end_time'])
            : null;

        return response()->json($event);
    }

    private function toAppTimezone($dateTime)
    {
        return Carbon::createFromFormat(\DateTime::ISO8601, $dateTime)
            ->toDateTimeString();
    }
}
