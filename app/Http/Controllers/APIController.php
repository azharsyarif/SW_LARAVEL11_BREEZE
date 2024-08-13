<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class APIController extends Controller
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function getCities()
    {
        $cities = $this->cityService->fetchCities();
        return response()->json($cities);
    }
}
