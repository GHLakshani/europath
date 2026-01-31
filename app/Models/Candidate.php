<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\CandidateStatus;

class Candidate extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'registration_no',
        'reference_no',
        'full_name',
        'nic',
        'passport_no',
        'passport_expiry',
        'dob',
        'age',

        'contact_number_1',
        'contact_number_2',
        'address',
        'place_of_birth',
        'civil_status',
        'no_of_children',
        'nationality',
        'religion',
        'father_name',
        'mother_name',
        'height_cm',
        'weight_kg',

        'education',
        'experience_years',
        'country_id',
        'job_id',
        'agent_id',
        'sub_dealer_id',
        'photo',
        'status',
        'created_by'
    ];

    protected $casts = [
        'passport_expiry' => 'date',
        'dob' => 'date'
    ];

    /* Relationships */
    public function country() { return $this->belongsTo(Country::class); }
    public function job() { return $this->belongsTo(CandidateJob::class); }
    public function agent() { return $this->belongsTo(Agent::class); }
    public function subDealer() { return $this->belongsTo(SubDealer::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }

    public function documents()
    {
        return $this->hasMany(CandidateDocument::class);
    }

    public function documentChecklist()
    {
        return $this->hasMany(CandidateDocument::class);
    }


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function visa()
    {
        return $this->hasOne(VisaProcess::class);
    }

    public function departure()
    {
        return $this->hasOne(Departure::class);
    }

    public function educations()
    {
        return $this->hasMany(CandidateEducation::class);
    }

    public function experiences()
    {
        return $this->hasMany(CandidateExperience::class);
    }

    public function languages()
    {
        return $this->hasMany(CandidateLanguage::class);
    }

}
