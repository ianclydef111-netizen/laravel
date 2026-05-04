<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model {
protected $fillable = ['medicine_id', 'batch_number', 'manufacture_date', 'expiry_date', 'stock_quantity'];

    protected $casts = ['expiry_date' => 'date', 'manufacture_date' => 'date'];

    public function medicine() { return $this->belongsTo(Medicine::class); }

    public function isExpired(): bool { return $this->expiry_date->isPast(); }
    public function isExpiringSoon(): bool { return $this->expiry_date->diffInDays(now()) <= 30 && !$this->isExpired(); }

    public function getBatchIdNumberDisplayAttribute() {
        return $this->batch_id_number ?: 'BAT' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
}