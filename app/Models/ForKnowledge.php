<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForKnowledge extends Model
{
    protected $table = "for_knowledge";
    protected $fillable = ['user_id','procedure_id'];
}
