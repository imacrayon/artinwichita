<?php

namespace App\Services\Maps;

use GuzzleHttp\Client;

class Geocoder implements Contracts\Geocoder
{
    public const SUCCESS = 'OK';

    protected $baseURL = 'https://maps.google.com/maps/api/geocode/json';

    private $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function request($address)
    {
        $response = (new Client)->get($this->baseURL, [
            'query' => [
                'key' => $this->key,
                'address' => $address,
            ]
        ]);

        $data = json_decode($response->getBody(), true);

        if ($data['status'] === self::SUCCESS) {
            return $data['results'][0];
        }

        throw new \Exception("Geocoding failed with status code {$response->status}.");
    }

    private function flattenComponentResponse($response)
    {
        $components = [];
        foreach ($response as $component) {
            foreach ($component['types'] as $type) {
                $components[$type] = $component['long_name'];
            }
        }

        return $components;
    }

    public function locate($address)
    {
        $response = $this->request($address);

        $location = $response['geometry']['location'];

        $components = $this->flattenComponentResponse(
            $response['address_components']
        );

        $components['address_line_1'] = trim(
            ($components['street_number'] ?? '') . ' ' . ($components['route'] ?? '')
        );

        return [
            'address_line_1' => $components['address_line_1'],
            'address_line_2' => null,
            'city' => $components['locality'] ?? 'Wichita',
            'state' => $components['administrative_area_level_1'] ?? 'Kansas',
            'postal_code' => $components['postal_code'] ?? null,
            'latitude' => $location['lat'],
            'longitude' => $location['lng']
        ];
    }
}
