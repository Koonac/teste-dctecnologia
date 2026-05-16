<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
    ];
    
    public function orders() {
        return $this->hasMany(Order::class);
    }
    public function payments() {
        return $this->hasMany(PaymentOrder::class);
    }
}
