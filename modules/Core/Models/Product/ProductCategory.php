<?php

namespace Core\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Core\Models\Product\Product;
use Core\Models\Product\Subcategory;
use Carbon\Carbon;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'meta'];

    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\ProductCategory::new();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function getTranslatedCreatedAtAttribute()
    {
        return Carbon::translateTimeString($this->created_at->toFormattedDateString(), 'en', 'tr');
    }
}
