<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'unpaid_order',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getUnpaidOrderAttribute()
    {
        $processedStatus = PaidStatus::where('slug', 'process')->first();
        $productUnpaid = Product::where('created_by', auth()->user()->id)
            ->where('paid_status_id', $processedStatus->id)
            ->count();
        $balanceUnpaid = Balance::where('created_by', auth()->user()->id)
            ->where('paid_status_id', $processedStatus->id)
            ->count();

        return ($productUnpaid+$balanceUnpaid);
    }

    public function balances()
    {
        return $this->hasMany(Balance::class, 'created_by');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'created_by');
    }
}
