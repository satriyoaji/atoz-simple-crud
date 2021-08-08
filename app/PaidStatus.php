<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidStatus extends Model
{
    protected $fillable = [
        'slug', 'name',
    ];

    public function balances()
    {
        return $this->hasMany(Balance::class, 'paid_status_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'paid_status_id');
    }
}
