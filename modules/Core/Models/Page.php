<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';

    protected $fillable = ['title', 'content', 'slug'];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Database\Factories\Page::new();
    }

    public function getTranslatedCreatedAtAttribute()
    {
        return Carbon::translateTimeString($this->created_at->toFormattedDateString(), 'en', 'tr');
    }
}
