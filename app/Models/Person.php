<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = "people";
    protected $fillable = ['name', 'last_name', 'second_last_name', 'phone', 'address', 'identity_number', 'email', 'identity_type_id'];

    public function legal_people()
    {
        return $this->belongsToMany(Person::class, 'legal_representatives', 'person_id', 'legal_person_id');
    }
    public function legal_representatives()
    {
        return $this->hasMany(LegalRepresentative::class, 'person_id', 'id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'person_id', 'id');
    }
    public function identity_type()
    {
        return $this->belongsTo(IdentityType::class, 'identity_type_id', 'id');
    }
    public function procedures()
    {
        return $this->morphMany(Procedure::class, 'applicant');
    }
    // Accessor para concatenar los nombres y apellidos
    protected function FullName(): Attribute
    {
        return Attribute::make(
            get: fn() => "{$this->name} {$this->last_name} {$this->second_last_name}"
        );
    }
}
