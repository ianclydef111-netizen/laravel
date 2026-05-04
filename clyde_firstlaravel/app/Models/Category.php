<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
protected $fillable = ['name', 'description', 'category_id_number'];
    protected $appends = ['category_id_number_display'];
public function medicines() { return $this->hasMany(Medicine::class); }

    public function getCategoryIdNumberDisplayAttribute() {
        return $this->category_id_number ?: 'CAT' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}