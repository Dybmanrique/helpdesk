<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalPerson extends Model
{
    protected $table = "legal_people";
    protected $fillable = ['ruc', 'company_name'];

    public function people()
    {
        return $this->belongsToMany(Person::class, 'legal_representatives', 'legal_person_id', 'person_id');
    }
    public function legal_representatives()
    {
        return $this->hasMany(LegalRepresentative::class, 'legal_person_id', 'id');
    }
}
