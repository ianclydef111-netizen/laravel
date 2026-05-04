<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model {
protected $fillable = ['supplier_name', 'contact_person', 'contact_no', 'email', 'address', 'supplier_id_number'];
    protected $appends = ['supplier_id_number_display'];
public function medicines() { return $this->hasMany(Medicine::class); }

    public function getSupplierIdNumberDisplayAttribute() {
        return $this->supplier_id_number ?: 'SUP' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}