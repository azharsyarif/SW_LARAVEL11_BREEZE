<?php

namespace App\Models;

use App\Services\CityService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class IntruksiJalan extends Model
{
    use HasFactory;

    protected $table = 'instruksi_jalans';

    protected $fillable = [
        'order_id',
        'driver_id',
        'kenek_id',
        'nopol',
        'tanggal_jalan',
        'tanggal_stuffing',
        'tanggal_stripping',
        'estimasi_waktu_ke_tujuan',
        'estimasi_jarak'
    ];

    public function order()
{
    return $this->belongsTo(Order::class);
}

public function driver()
{
    return $this->belongsTo(User::class, 'driver_id');
}

public function kenek()
{
    return $this->belongsTo(User::class, 'kenek_id');
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

protected static function boot()
    {
        parent::boot();

        static::creating(function ($instruksi) {
            $lastInstruksi = IntruksiJalan::orderBy('id', 'desc')->first();
            $nextNumber = $lastInstruksi ? $lastInstruksi->id + 1 : 1;
            $instruksi->no_surat_jalan = 'SJ-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        });
    }

    protected $casts = [
        'tanggal_jalan' => 'datetime',
    ];
}
