<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadastral_record',
        'department_id',
        'municipality_id',
        'village_id',
        'name',
        'ubication',
        'total_area',
        'holding_id',
        'other_holding',
        'available_area',
        'user_id'
    ];

    public function department()
    {
        return $this->hasOne('App\Models\Department', 'department_id');
    }

    public function municipality()
    {
        return $this->hasOne('App\Models\Municipality', 'municipality_id');
    }

    public function village()
    {
        return $this->hasOne('App\Models\Village', 'village_id');
    }

    public function holding()
    {
        return $this->hasOne('App\Models\Holding', 'holding_id');
    }

    public function lots()
    {
        return $this->hasMany('App\Models\Lot', 'farm_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
