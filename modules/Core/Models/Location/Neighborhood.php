<?php

namespace Core\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;

    protected $table = 'locations_neighborhoods';

    protected $fillable = ['district_id', 'name'];
}
