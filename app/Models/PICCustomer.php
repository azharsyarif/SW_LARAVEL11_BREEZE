<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PICCustomer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function rekanan()
    {
        return $this->belongsTo(Rekanan::class, 'nama_pt', 'id');
    }
}
