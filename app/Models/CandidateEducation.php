<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateEducation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'institute_name',
        'course',
        'duration',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
