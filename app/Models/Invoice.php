<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function rekanan()
    {
        return $this->belongsTo(Rekanan::class, 'rekanan_id');
    }

public function orders()
{
    return $this->belongsToMany(Order::class, 'invoice_order');
}

public function poCustomer()
{
    return $this->belongsTo(POCustomer::class, 'no_po_customer');
}


    public function payment()
    {
        return $this->hasOne(Payment::class, 'invoice_id');
    }
}
