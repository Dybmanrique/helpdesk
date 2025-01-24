<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureCategory extends Model
{
    protected $table = "procedure_categories";
    protected $fillable = ['nombre'];

    public function procedures(){
        return $this->hasMany(Procedure::class,'procedure_category_id','id');
    }
}
