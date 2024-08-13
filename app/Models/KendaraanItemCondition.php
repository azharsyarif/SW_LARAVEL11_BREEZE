<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KendaraanItemCondition extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function serviceKendaraan()
    {
        return $this->belongsTo(ServiceKendaraan::class);
    }
}
