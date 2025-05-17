<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalRepresentative extends Model
{
    protected $table = "legal_representatives";
    protected $fillable = ['person_id', 'legal_person_id'];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }
    public function legal_person()
    {
        return $this->belongsTo(LegalPerson::class, 'legal_person_id', 'id');
    }
    public function procedures()
    {
        return $this->morphMany(Procedure::class, 'applicant');
    }
}
