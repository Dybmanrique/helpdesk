<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionFile extends Model
{
    protected $table = "action_files";
    protected $fillable = ['name','path','action_id'];

    public function action(){
        return $this->belongsTo(Action::class,'action_id','id');
    }
}
