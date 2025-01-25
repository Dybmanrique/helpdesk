<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedurePriority extends Model
{
    protected $table = "procedure_priorities";
    protected $fillable = ['name'];

    public function procedures(){
        return $this->hasMany(Procedure::class,'procedure_priority_id','id');
    }
}
