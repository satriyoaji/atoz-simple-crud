<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'mobile_phone', 'value', 'price', 'order_no'
    ];

    protected $appends = [
        'type',
    ];


    public function getTypeAttribute()
    {
        return 'balance';
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function paidStatus()
    {
        return $this->belongsTo(PaidStatus::class, 'paid_status_id');
    }
}
