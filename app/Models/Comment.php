<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = "comments";
    protected $fillable = ['comment','procedure_id','office_id'];

    public function procedure(){
        return $this->belongsTo(Procedure::class,'procedure_id','id');
    }
    public function office(){
        return $this->belongsTo(Office::class,'office_id','id');
    }
}
