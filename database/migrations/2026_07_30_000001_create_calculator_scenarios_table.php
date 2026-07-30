<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculator_scenarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->string('name');
            $table->string('platform', 32)->default('amazon');
            $table->decimal('fee_percent', 5, 2)->default(15.00);
            $table->decimal('flat_fee', 8, 2)->default(0.00);
            $table->json('products');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculator_scenarios');
    }
};
