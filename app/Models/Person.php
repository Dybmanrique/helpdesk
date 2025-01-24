<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = "persons";
    protected $fillable = ['nombre','apellido_paterno','apellido_materno','celular','direccion','dni'];

    public function legal_person(){
        return $this->hasOne(LegalPerson::class,'person_id','id');
    }
    public function user(){
        return $this->hasOne(User::class,'person_id','id');
    }
}
