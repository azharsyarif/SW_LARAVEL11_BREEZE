<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisions extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function users()
    {
        return $this->belongsToMany(User::class, 'user_division', 'division_id', 'user_id')->withTimestamps();
    }
    

    public function divisions()
{
    return $this->belongsToMany(Divisions::class, 'user_division', 'user_id', 'division_id');
}
}
