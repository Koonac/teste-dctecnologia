<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $fillable = [
        'client_id',
        'user_id',
        'total',
        'status',
        'payment_method',
        'installment_count',
    ];
    
    public function client() {
        return $this->belongsTo(Client::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function products() {
        return $this->hasMany(ProductOrder::class);
    }
    public function payments() {
        return $this->hasMany(PaymentOrder::class);
    }
}
