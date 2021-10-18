<?php

namespace Core\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Core\Models\Location\District;
use Core\Models\Location\Neighborhood;

class City extends Model
{
    use HasFactory;

    protected $table = 'locations_cities';

    protected $fillable = ['name'];

    public function districts()
    {
        return $this->hasMany(District::class)->orderBy('name', 'ASC');
    }

    public function neighborhoods()
    {
        return $this->hasManyThrough(Neighborhood::class, District::class)->orderBy('name', 'ASC');
    }
}
