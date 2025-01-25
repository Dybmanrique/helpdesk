<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentityType extends Model
{
    protected $table = "identity_types";
    protected $fillable = ['name'];

    public function person(){
        return $this->hasMany(Person::class,'identity_type_id','id');
    }
}
