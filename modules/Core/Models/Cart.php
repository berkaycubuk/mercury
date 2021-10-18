<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marketing\Coupon;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user',
        'items',
        'meta',
        'ip',
    ];

    protected $casts = [
        'items' => 'array',
        'meta' => 'array',
    ];

    public function getCouponsAttribute()
    {
        if (isset($this->meta['coupons']) && !empty($this->meta['coupons'])) {
            return Coupon::whereIn('id', $this->meta['coupons'])->get();
        }

        return [];
    }

    public function getTaxAttribute()
    {
        // TODO: add coupon stuff to tax
        $tax = 0;

        if ($this->items == null || count($this->items) == 0) {
            return $tax;
        }

        foreach ($this->items as $item) {
            $tax += $item['tax'] * $item['amount'];    
        }

        return $tax;
    }

    public function getTotalPriceAttribute()
    {
        $total = 0;
        if ($this->items == null || count($this->items) == 0) {
            return $total;
        }

        foreach ($this->items as $item) {
            $total += ($item['price'] + $item['tax']) * $item['amount'];
        }

        // coupons
        foreach ($this->coupons as $coupon) {
            if ($coupon->discount_type == 'fixed-cart') {
                $total-= $coupon->discount;
            } else if ($coupon->discount_type = 'percent-cart') {
                $total-= ($total* $coupon->discount) / 100;
            }
        }

        return $total;
    }
}
