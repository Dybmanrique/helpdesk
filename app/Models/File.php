<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = "files";
    protected $fillable = ['name', 'path'];

    public function actions()
    {
        return $this->hasMany(Action::class, 'file_id', 'id');
    }
    public function procedures()
    {
        return $this->hasMany(Procedure::class, 'file_id', 'id');
    }
    public function resolutions()
    {
        return $this->hasMany(Resolution::class, 'file_id', 'id');
    }
}
