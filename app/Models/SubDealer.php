<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubDealer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'nic',
        'phone',
        'commission_percentage',
        'is_active'
    ];

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
