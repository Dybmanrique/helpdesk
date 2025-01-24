<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureState extends Model
{
    protected $table = "procedure_states";
    protected $fillable = ['nombre'];

    public function procedures(){
        return $this->hasMany(Procedure::class,'procedure_state_id','id');
    }
}
