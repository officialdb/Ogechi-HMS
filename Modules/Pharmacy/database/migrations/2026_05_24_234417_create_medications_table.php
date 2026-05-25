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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('category'); // e.g. Tablet, Syrup, Injection
            $table->string('manufacturer')->nullable();
            $table->integer('quantity_in_stock')->default(0);
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->date('expiry_date')->nullable();
            $table->enum('status', ['available', 'low_stock', 'out_of_stock', 'expired'])->default('available');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
