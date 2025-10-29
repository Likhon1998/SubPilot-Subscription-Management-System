<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckoutCustomer extends Model
{
    use HasFactory;

    protected $table = 'checkout_customers';

    // Fields that can be mass assigned
    protected $fillable = [
        'name',
        'email',
        'phone',
        'otp',
        'otp_verified',
        'otp_expires_at',
        'checkout_completed',
    ];

    // Casts
    protected $casts = [
        'otp_verified' => 'boolean',
        'checkout_completed' => 'boolean',
        'otp_expires_at' => 'datetime',
    ];

     public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'checkout_customer_id');
    }
}
