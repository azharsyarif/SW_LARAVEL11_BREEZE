<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
