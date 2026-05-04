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
    Schema::create('medicines', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
        $table->string('generic_name');
        $table->string('brand_name')->nullable();
        $table->decimal('unit_price', 10, 2);
        $table->integer('stock_level')->default(0);
        $table->integer('reorder_level')->default(10);
        $table->boolean('is_regulated')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
