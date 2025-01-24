<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $fillable = ['comentario','procedure_id','office_id'];

}
