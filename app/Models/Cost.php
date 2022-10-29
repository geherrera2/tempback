<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;
    protected $fillable = ['type_cost_id', 'type_category_id', 'type_activity_id', 'farm_id', 'lot_id', 'stage_id', 'type_work_id', 'amount', 'unit_cost', 'description'];

    public function typeCost()
    {
        return $this->belongsTo('App\Models\TypeCost', 'type_cost_id');
    }

    public function typeCategory()
    {
        return $this->belongsTo('App\Models\TypeCategory', 'type_category');
    }

    public function typeActivity()
    {
        return $this->belongsTo('App\Models\TypeActivity', 'type_activity');
    }

    public function farm()
    {
        return $this->belongsTo('App\Models\Farm', 'farm_id');
    }

    public function lot()
    {
        return $this->belongsTo('App\Models\Lot', 'lot_id');
    }

    public function stage()
    {
        return $this->belongsTo('App\Models\Stage', 'stage_id');
    }

    public function typeWork()
    {
        return $this->belongsTo('App\Models\TypeWork', 'type_work_id');
    }

    public function supplies()
    {
        return $this->belongsToMany('App\Models\Supplie', 'cost_supplie', 'cost_id', 'supplie_id');
    }

    public function scopeInitialDate($query, $date){
        if($date){
            return $query->whereDate('costs.created_at', '>=', $date);
        }
        return $query;
    }

    public function scopeFinalDate($query, $date){
        if($date){
            return $query->whereDate('costs.created_at', '<=', $date);
        }
        return $query;
    }
}
