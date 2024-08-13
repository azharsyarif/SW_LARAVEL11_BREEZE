<?php

namespace App\Services;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class CityService
{
    /**
     * Create a new class instance.
     */
    // public function __construct()
    // {
    //     //
    // }
    public function fetchCities()
{
    $cachedCities = Cache::get('cities');

    if (!$cachedCities) {
        $client = new Client();
        $response = $client->request('GET', 'https://api.rajaongkir.com/starter/city', [
            'headers' => [
                'key' => 'b4207a547a445d57b42ea7ab7d432b5b'
            ]
        ]);

        $cities = json_decode($response->getBody(), true)['rajaongkir']['results'];

        // Log the cities array to ensure it's correctly fetched
        \Log::info('Cities fetched:', $cities);

        Cache::put('cities', $cities, now()->addHours(6)); // Cache for 6 hours
    } else {
        $cities = $cachedCities;
    }

    return $cities;
}

}
