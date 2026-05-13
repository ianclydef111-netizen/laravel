<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model {
protected $fillable = ['category_id', 'supplier_id', 'medicine_id_number', 'generic_name', 'brand_name', 'unit_price', 'stock_level', 'reorder_level', 'is_regulated'];

    public function category() { return $this->belongsTo(Category::class); }
    public function supplier() { return $this->belongsTo(Supplier::class); }
    public function batches() { return $this->hasMany(Batch::class); }
    public function saleItems() { return $this->hasMany(SaleItem::class); }
    public function prescriptions() {
        return $this->belongsToMany(Prescription::class, 'prescription_medicines')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function isLowStock(): bool { return $this->stock_level <= $this->reorder_level; }
}
