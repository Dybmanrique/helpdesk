<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Derivation extends Model
{
    protected $table = "derivations";
    protected $fillable = ['comentario','office_id','procedure_id'];

}
