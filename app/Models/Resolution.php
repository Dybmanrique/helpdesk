<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resolution extends Model
{
    protected $table = "resolutions";
    protected $fillable = ['resolution_number','description','user_id','resolution_type_id','resolution_state_id'];

    public function file_resolution(){
        return $this->hasOne(ResolutionFile::class);
    }
}
