<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateExperience extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'employer_name',
        'position',
        'duration',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
