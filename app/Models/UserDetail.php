<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_type_id',
        'number',
        'celphone',
        'therms_and_conditions',
        'business_name',
        'name',
        'last_name'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
