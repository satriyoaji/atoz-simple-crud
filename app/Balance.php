<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'mobile_phone', 'value', 'price', 'order_no'
    ];
}
