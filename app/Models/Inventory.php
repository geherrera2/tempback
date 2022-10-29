<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['provider', 'nit', 'invoice_number', 'user_id', 'date'];
    use HasFactory;

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'inventory_product', 'inventory_id', 'product_id')->withPivot([
            'amount',
            'unit_cost',
            'total_cost',
            'created_at',
            'updated_at'
        ])->withTimestamps();
    }
}
