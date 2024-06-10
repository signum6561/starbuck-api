<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malico\LaravelNanoid\HasNanoids;

class Invoice extends Model
{
    use HasFactory, HasNanoids;
    protected $nanoidLength = 18;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
