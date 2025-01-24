<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = "files";
    protected $fillable = ['storage','procedure_id'];

    public function procedure(){
        return $this->belongsTo(Procedure::class,'procedure_id','id');
    }
}
