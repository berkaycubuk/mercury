<?php

namespace Core\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Core\Models\Product\ProductCategory;
use Core\Models\Product\Subcategory;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $casts = [
        'images' => 'array',
        'meta' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'short_description',
        'slug',
        'price',
        'images',
        'product_category_id',
        'subcategory_id',
        'meta'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\Product::new();
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function getInStockAttribute()
    {
        if (!isset($this->meta['stock_amount']) || (isset($this->meta['stock_amount']) && $this->meta['stock_amount'] == null)) {
            return true;
        }

        if ($this->meta['stock_amount'] > 0) {
            return true;
        }

        return false;
    }

    public function getStockAmountAttribute()
    {
        if (!isset($this->meta['stock_amount']) || (isset($this->meta['stock_amount']) && $this->meta['stock_amount'] == null)) {
            return null;
        }

        return $this->meta['stock_amount'];
    }

    public function getTranslatedCreatedAtAttribute()
    {
        return Carbon::translateTimeString($this->created_at->toFormattedDateString(), 'en', 'tr');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function getInitialPriceAttribute()
    {
        if (!isset($this->meta['attributes'])) {
            return $this->getPriceWithTaxAttribute();
        }

        $total = 0;
        foreach ($this->meta['attributes'] as $attribute) {
            if (count($attribute['terms']) > 0) {
                if ($attribute['terms'][0]['price'] == 0) {
                    $total += $this->price;
                } else {
                    $total += $attribute['terms'][0]['price'];
                }
            } 
        }

        if ($total == 0) {
            $total = $this->price;
        }

        if (!isset($this->meta['tax'])) {
            return $total;
        }

        return ($total * $this->meta['tax']) / 100 + $total;
    }

    public function getPriceWithTaxAttribute()
    {
        if (!isset($this->meta['tax'])) {
            return $this->price;
        }

        return ($this->price * $this->meta['tax']) / 100 + $this->price;
    }

    public function getDiscountedPriceWithTaxAttribute()
    {
        if (!isset($this->meta['tax'])) {
            if (isset($this->meta['discount_price'])) {
               return $this->meta['discount_price'];
            }

            return $this->price;
        }

        return ($this->meta['discount_price'] * $this->meta['tax']) / 100 + $this->meta['discount_price'];
    }

    /**
     * Format price as understandable string
     *
     * @return string
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price , 2, ',', '.') . '₺';
    }

    public function getAttributesAttribute()
    {
        if (isset($this->meta['attributes'])) {
            return $this->meta['attributes'];
        }

        return [];
    }
}
