<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'category',
        'description',
        'created_date',
    ];

    protected $casts = [
        'created_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function getTotalValueAttribute(): float
    {
        return (float) $this->price * (int) $this->quantity;
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->quantity == 0) {
            return 'Out of Stock';
        }

        if ($this->quantity < 10) {
            return 'Low Stock';
        }

        return 'In Stock';
    }

    public function getStockStatusClassAttribute(): string
    {
        if ($this->quantity == 0) {
            return 'danger';
        }

        if ($this->quantity < 10) {
            return 'warning';
        }

        return 'success';
    }
}
