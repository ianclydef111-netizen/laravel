<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
    Schema::create('batches', function (Blueprint $table) {
        $table->id();
        $table->foreignId('medicine_id')->constrained()->onDelete('cascade');
        $table->string('batch_number');
        $table->date('manufacture_date')->nullable();
        $table->date('expiry_date');
        $table->integer('stock_quantity');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
