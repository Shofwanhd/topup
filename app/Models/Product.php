<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['name', 'slug', 'uuid', 'description', 'category_id', 'pic', 'is_active'])]
class Product extends Model
{
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });

        static::saving(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variation(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
