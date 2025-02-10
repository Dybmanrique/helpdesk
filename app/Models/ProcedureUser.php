<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureUser extends Model
{
    protected $table = "procedure_user";
    protected $fillable = ['user_id','procedure_id'];
}
