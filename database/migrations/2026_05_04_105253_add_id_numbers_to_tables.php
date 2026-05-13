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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('category_id_number')->unique()->nullable()->after('id');
        });

        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('supplier_id_number')->unique()->nullable()->after('id');
        });



        Schema::table('prescriptions', function (Blueprint $table) {
            $table->string('prescription_id_number')->unique()->nullable()->after('id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('user_id_number')->unique()->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_categories_suppliers_batches_prescriptions');
    }
};
