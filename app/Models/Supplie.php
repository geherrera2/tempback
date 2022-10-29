<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplie extends Model
{
    use HasFactory;
    protected $fillable = ['cost_id', 'product_id', 'amount'];

    public function costs()
    {
        return $this->belongsToMany('App\Models\Cost', 'cost_supplie', 'supplie_id', 'cost_id');
    }
}
