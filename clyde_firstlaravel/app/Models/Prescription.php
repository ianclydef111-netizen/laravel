<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model {
protected $fillable = ['patient_name', 'doctor_name', 'file_path', 'prescription_date', 'status', 'notes', 'prescription_id_number'];
    protected $appends = ['prescription_id_number_display'];
    protected $casts = [
        'prescription_date' => 'date',
    ];

    public function getPrescriptionIdNumberDisplayAttribute() {
        return $this->prescription_id_number ?: 'PRE' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }

    public function sales() { return $this->hasMany(Sale::class); }
    public function medicines() {
        return $this->belongsToMany(Medicine::class, 'prescription_medicines')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
}
