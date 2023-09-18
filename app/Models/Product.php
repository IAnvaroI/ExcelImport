<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'manufacturer',
        'name',
        'sku',
        'description',
        'price',
        'is_available',
    ];

    /**
     * Get the category of product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
