<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResolutionFile extends Model
{
    protected $table = "resolution_files";
    protected $fillable = ['resolution_id', 'file_id'];


    public function file(){
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
