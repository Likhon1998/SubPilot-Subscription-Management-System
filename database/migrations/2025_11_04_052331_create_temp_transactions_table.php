<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temp_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tran_id')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->text('item_ids'); // store multiple item IDs as JSON
            $table->integer('duration');
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_transactions');
    }
};
