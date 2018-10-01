<?php

namespace App\Http\Controllers\Api;

use App\Event;
use App\Place;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\ValidationException;

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

        $settings = $request->user()->settings();

        if (! $settings->has('facebook_token')) {
            return abort(403, 'You must login through Facebook to do this.');
        }

        $eventId = $this->parseEventIdFromUrl($request->url);

        return $this->fetchFacebookEvent($eventId, $settings->get('facebook_token'));
    }

    private function parseEventIdFromUrl($url)
    {
        return array_get(explode('/', parse_url($url, PHP_URL_PATH)), 2);
    }

    private function fetchFacebookEvent($id, $accessToken)
    {
        try {
            $response = (new Client)->get("https://graph.facebook.com/{$id}?fields=id,start_time,end_time,name,description,place,cover", [
                'headers' => ['Accept' => 'application/json'],
                'query' => ['access_token' => $accessToken]
            ]);
        } catch (ClientException $e) {
            throw ValidationException::withMessages(['url' => 'There was an error fetching an event from this URL.']);
        }

        $data = json_decode($response->getBody(), true);

        return response()->json($this->parseEventData($data));
    }

    private function toAppTimezone($dateTime)
    {
        return Carbon::createFromFormat(\DateTime::ISO8601, $dateTime)
            ->toDateTimeString();
    }

    private function parseEventData($data)
    {
        return tap(new Event, function ($event) use ($data) {
            $event->name = $data['name'];
            $event->start_time = $this->toAppTimezone($data['start_time']);
            $event->end_time = isset($data['end_time'])
                ? $this->toAppTimezone($data['end_time'])
                : null;
            $event->description = $data['description'] ?? null;
            $event->place = $this->parsePlaceData($data['place']);
            $event->image = $data['cover']['source'] ?? null;
        });
    }

    private function parsePlaceData($data)
    {
        return tap(new Place, function ($place) use ($data) {
            $place->name = $data['name'];
            if (isset($data['location'])) {
                $data['location']['address_line_1'] = $data['location']['street'];
                $place->fill($place['location']);
            }
            $place->geocode();
        });
    }
}
