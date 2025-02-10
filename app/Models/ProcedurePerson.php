<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedurePerson extends Model
{
    protected $table = "procedure_person";
    protected $fillable = ['person_id','procedure_id'];
}
