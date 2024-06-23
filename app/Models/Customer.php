<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Malico\LaravelNanoid\HasNanoids;

class Customer extends Model
{
    use HasFactory, Filterable, Sortable, HasNanoids;
    protected $nanoidLength = 20;
    protected $fillable = [
        'fullname',
        'email',
        'address',
        'birthday',
        'star_points',
        'type',
    ];

    protected $renamedFilterFields = [
        'fullname',
        'email',
        'address',
        'birthday',
        'star_points' => 'starPoints',
        'type'
    ];

    protected $sortFields = [
        'fullname',
        'email',
        'birthday',
        'star_points' => 'starPoints',
        'created_at' => 'createdAt'
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->orderBy('billed_date', 'desc');
    }
}
