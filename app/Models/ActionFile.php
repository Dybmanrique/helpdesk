<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActionFile extends Model
{
    protected $table = "action_files";
    protected $fillable = ['name', 'action_id', 'file_id'];

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }
}
