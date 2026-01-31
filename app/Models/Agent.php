<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country_id',
        'name',
        'nic',
        'phone',
        'email',
        'commission_percentage',
        'is_active'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
