<?php

namespace App\Models;

use App\Services\CityService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id']; 

    // Define relationships
    public function rekanan()
    {
        return $this->belongsTo(Rekanan::class, 'rekanan_id');
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function poCustomer()
    {
        return $this->belongsTo(POCustomer::class, 'no_po', 'id');
    }
    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_order');
    }

    public function asalCity()
    {
        $cityService = App::make(CityService::class); 
        $cities = $cityService->fetchCities();
        $city = collect($cities)->firstWhere('city_id', $this->asal);
    return $city['city_name'] ?? 'Unknown';
    }

    // Fetch city name from `tujuan` city ID
    public function tujuanCity()
    {
        $cityService = App::make(CityService::class);
        $cities = $cityService->fetchCities();
        $city = collect($cities)->firstWhere('city_id', $this->tujuan);
        return $city['city_name'] ?? 'Unknown';
    }


    // Custom attribute for formatted order
    public function formattedOrder()
    {
        return $this->no_order . ' - ' . $this->tujuanCity();
    }
}
