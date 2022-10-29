<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilAnalysis extends Model
{
    use HasFactory;

    protected $fillable = [
        'analysis_date',
        'ph',
        'organic_matter',
        'phosphates',
        'calcium',
        'magnesium',
        'potassium',
        'aluminum',
        'sulphur',
        'texture',
        'lot_id'
    ];

    public function lot()
    {
        return $this->belongsTo('App\Models\Lot', 'lot_id');
    }

}
