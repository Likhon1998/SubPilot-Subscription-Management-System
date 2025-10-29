<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('checkout_customer_id')->constrained()->onDelete('cascade'); // Link to user info
            $table->foreignId('item_id')->constrained()->onDelete('cascade'); // Selected item
            $table->integer('duration'); // in months
            $table->decimal('total_amount', 10, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('active')->default(true);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
