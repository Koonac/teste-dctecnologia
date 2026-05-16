<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentOrder extends Model
{
    protected $table = 'payments_orders';

    protected $fillable = [
        'order_id',
        'client_id',
        'status',
        'value',
        'due_date',
        'payment_date',
    ];
    
    public function order() {
        return $this->belongsTo(Order::class);
    }
    public function client() {
        return $this->belongsTo(Client::class);
    }
}
