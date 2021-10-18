<?php

namespace Core\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $table = 'product_attributes';

    protected $fillable = [
        'name',
        'terms'
    ];

    public function getTermsJsonAttribute()
    {
        if ($this->terms == null) {
            return [];
        }

        return json_decode($this->terms);
    }
}
