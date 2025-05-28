<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureCounter extends Model
{
    protected $table = "procedure_counters";
    protected $fillable = ['year', 'last_number'];
    protected $primaryKey = 'year';
    public $incrementing = false;
    protected $keyType = 'int';
}
