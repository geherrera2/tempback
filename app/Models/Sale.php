<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'farm_id',
        'lot_id',
        'amount_loads',
        'sale_value',
        'buyer',
        'sales_type_coffee_id',
        'kilos_coffee_prod',
        'kilos_coffee_des',
        'bonus',
        'bonus_other',
        'sale_value_base',

    ];

    public function farm()
    {
        return $this->belongsTo('App\Models\Farm', 'farm_id');
    }

    public function lot()
    {
        return $this->belongsTo('App\Models\Lot', 'lot_id');
    }
}
