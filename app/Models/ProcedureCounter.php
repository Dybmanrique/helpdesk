<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureCounter extends Model
{
    protected $table = "procedure_counters";
    protected $fillable = ['year', 'last_number'];
}
