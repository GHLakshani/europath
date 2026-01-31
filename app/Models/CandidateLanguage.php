<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateLanguage extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'candidate_id',
        'language',
        'understanding',
        'speaking',
        'writing',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
