<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Medicine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@pharmacy.com',
            'password' => Hash::make('Admin@1234'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Pharmacist John',
            'email' => 'pharmacist@pharmacy.com',
            'password' => Hash::make('Pharma@1234'),
            'role' => 'pharmacist',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Sales Clerk Jane',
            'email' => 'sales@pharmacy.com',
            'password' => Hash::make('Sales@1234'),
            'role' => 'sales_clerk',
            'status' => 'pending',
        ]);

        // Sample categories
        $categories = ['Antibiotics', 'Analgesics', 'Vitamins', 'Antihistamines', 'Cardiovascular', 'Regulated'];
        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }

        // Sample suppliers
        $suppliers = [
            ['supplier_name' => 'PharmaCorp', 'contact_no' => '+1-555-0101', 'email' => 'sales@pharmcorp.com'],
            ['supplier_name' => 'Medix Supply', 'contact_no' => '+1-555-0102', 'email' => 'info@medix.com'],
            ['supplier_name' => 'HealthLink', 'contact_no' => '+1-555-0103', 'email' => 'orders@healthlink.com'],
        ];
        foreach ($suppliers as $sup) {
            Supplier::create($sup);
        }

        // Sample medicines
        $medicines = [
            ['category_id' => 1, 'supplier_id' => 1, 'generic_name' => 'Paracetamol', 'brand_name' => 'Panadol', 'unit_price' => 2.50, 'stock_level' => 100, 'reorder_level' => 20],
            ['category_id' => 1, 'supplier_id' => 2, 'generic_name' => 'Amoxicillin', 'brand_name' => 'Amoxil', 'unit_price' => 8.75, 'stock_level' => 50, 'reorder_level' => 10, 'is_regulated' => true],
            ['category_id' => 2, 'supplier_id' => 1, 'generic_name' => 'Ibuprofen', 'brand_name' => 'Brufen', 'unit_price' => 3.25, 'stock_level' => 75, 'reorder_level' => 15],
            ['category_id' => 3, 'supplier_id' => 3, 'generic_name' => 'Vitamin C', 'brand_name' => 'Ceevit', 'unit_price' => 1.99, 'stock_level' => 200, 'reorder_level' => 30],
            ['category_id' => 4, 'supplier_id' => 2, 'generic_name' => 'Cetirizine', 'brand_name' => 'Zyrtec', 'unit_price' => 4.50, 'stock_level' => 60, 'reorder_level' => 10],
        ];
        foreach ($medicines as $med) {
            Medicine::create($med);
        }
    }
}

