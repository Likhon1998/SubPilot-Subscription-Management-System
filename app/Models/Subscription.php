<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkout_customer_id',
        'item_id',
        'duration',
        'total_amount',
        'start_date',
        'end_date',
        'active', 
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'active' => 'boolean',
    ];

    public function customer()
    {
        return $this->belongsTo(CheckoutCustomer::class, 'checkout_customer_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
