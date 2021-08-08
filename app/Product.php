<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'address', 'price', 'order_no'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
