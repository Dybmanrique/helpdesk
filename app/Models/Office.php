<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "offices";
    protected $fillable = ['name','description'];
    
    public function derivations(){
        return $this->hasMany(Derivation::class,'office_id','id');
    }
    public function comments(){
        return $this->hasMany(Comment::class,'office_id','id');
    }
    public function users(){
        return $this->belongsToMany(User::class,'administrative_user','office_id','user_id');
    }
}
