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

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany(ProductOrder::class);
    }
    public function payments()
    {
        return $this->hasMany(PaymentOrder::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft'     => 'Rascunho',
            'pending'   => 'Pendente',
            'paid'      => 'Pago',
            'cancelled' => 'Cancelado',
            default     => $this->status,
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash'      => 'Dinheiro (à vista)',
            'pix'       => 'Pix (à vista)',
            'card'      => 'Cartão (à vista)',
            'installment' => 'Cartão (parcelado)',
            default     => $this->payment_method,
        };
    }
}
