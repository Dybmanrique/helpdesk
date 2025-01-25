<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "offices";
    protected $fillable = ['name','description'];

    public function administrative_users(){
        return $this->hasMany(AdministrativeUser::class,'office_id','id');
    }
    public function derivations(){
        return $this->hasMany(Derivation::class,'office_id','id');
    }
    public function comments(){
        return $this->hasMany(Comment::class,'office_id','id');
    }
}
