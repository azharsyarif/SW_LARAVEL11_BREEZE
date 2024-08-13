<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rekanan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function picCustomers()
    {
        return $this->hasMany(PICCustomer::class, 'nama_pt', 'id');
    }
    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

}
