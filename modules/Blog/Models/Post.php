<?php

namespace Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'content',
        'slug',
        'author',
        'category',
        'thumbnail'
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Blog\Database\Factories\Post::new();
    }

    public function getTranslatedCreatedAtAttribute()
    {
        return Carbon::translateTimeString($this->created_at->format('j F Y'), 'en', 'tr');
    }
}
