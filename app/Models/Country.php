<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'country_name',
        'order',
        'status',
        'is_active'
    ];

    public function jobs()
    {
        return $this->hasMany(CandidateJob::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
