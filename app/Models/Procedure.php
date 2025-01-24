<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $table = "procedures";
    protected $fillable = ['asunto','descripcion','ticket','user_id','procedure_prioriy_id','procedure_category_id','procedure_state_id','document_type_id'];

}
