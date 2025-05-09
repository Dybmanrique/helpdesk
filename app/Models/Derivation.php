<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Derivation extends Model
{
    protected $table = "derivations";
    protected $fillable = ['procedure_id','user_id', 'is_active'];

    public function procedure(){
        return $this->belongsTo(Procedure::class,'procedure_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function actions(){
        return $this->hasMany(Action::class);
    }
}
