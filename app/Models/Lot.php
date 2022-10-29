<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'total_area', 'ubication', 'above_sea_level', 'description', 'varietie_coffee_id', 'other_varietie_coffe', 'renewal_id', 'type_renewal_id', 'date_renewal',
        'age', 'brightness_id','number_plants', 'range_brightness', 'type_somber_id', 'stroke_id', 'distance_sites', 'distance_furrow', 'stems_sites', 'density_hectares', 'sites_crop',
        'farm_id'
    ];

    public function soils()
    {
        return $this->hasMany('App\Models\SoilAnalysis', 'lot_id');
    }
}
