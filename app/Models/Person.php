<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = "person";
    protected $fillable = ['name','last_name','second_last_name','phone','address','identity_number','identity_type'];

    public function legal_person(){
        return $this->hasOne(LegalPerson::class,'person_id','id');
    }
    public function user(){
        return $this->hasOne(User::class,'person_id','id');
    }
    public function identity_type(){
        return $this->belongsTo(IdentityType::class,'identity_type_id','id');
    }
}
