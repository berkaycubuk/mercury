<?php

namespace Core\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Core\Models\Location\Neighborhood;

class District extends Model
{
    use HasFactory;

    protected $table = 'locations_districts';

    protected $fillable = ['city_id', 'name'];

    public function neighborhoods()
    {
        return $this->hasMany(Neighborhood::class)->orderBy('name', 'ASC');
    }
}
