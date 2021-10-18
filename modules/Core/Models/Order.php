<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'orders';

    protected $casts = [
        'meta' => 'array'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user',
        'state',
        'meta'
    ];

    public function getTranslatedCreatedAtAttribute()
    {
        return Carbon::translateTimeString($this->created_at->format('H:i:s d.m.Y'), 'en', 'tr');
    }

    public function getStateTextAttribute()
    {
        if ($this->state == 0) {
            return 'Beklemede';
        } else if ($this->state == 1) {
            return 'Tamamlandı';
        } else if ($this->state == 2) {
            return 'Ödenmedi';
        } else if ($this->state == 3) {
            return 'İptal Edildi';
        } else if ($this->state == 4) {
            return 'Onaylandı';
        }
    }
}
