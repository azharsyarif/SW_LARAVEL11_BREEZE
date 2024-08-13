<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceKendaraan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function driver()
    {
        return $this->belongsTo(User::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'nopol', 'id');
    }

    public function kendaraanItemConditions()
    {
        return $this->hasMany(KendaraanItemCondition::class);
    }
}
