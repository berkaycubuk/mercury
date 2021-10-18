<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'coupons';

    protected $dates = ['expires_at'];

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount',
        'free_shipping',
        'expires_at',
        'meta'
    ];

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
        return \Database\Factories\Coupon::new();
    }

    public function getTranslatedCreatedAtAttribute()
    {
        return Carbon::translateTimeString($this->created_at->toFormattedDateString(), 'en', 'tr');
    }

    public function getTranslatedExpiresAtAttribute()
    {
        return Carbon::translateTimeString($this->expires_at->toFormattedDateString(), 'en', 'tr');
    }
}
