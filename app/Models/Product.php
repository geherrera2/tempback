<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable =  ['name', 'unit_measurement_id', 'product_type_id', 'user_id', 'total_amount'];

    public function product_type()
    {
        return $this->belongsTo('App\Models\ProductType', 'type_product_id');
    }

    public function unit_measurement()
    {
        return $this->belongsTo('App\Models\UnitMeasurement', 'unit_measurement_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function inventories()
    {
        return $this->belongsToMany('App\Models\Inventory', 'inventory_product', 'product_id', 'inventory_id');
    }
}
