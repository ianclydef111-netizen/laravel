<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'prescription_id', 
        'sale_date',
        'total_price',
        'customer_name',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
