<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = "actions";
    protected $fillable = ['comment', 'action', 'derivation_id'];

    public function derivation()
    {
        return $this->belongsTo(Derivation::class, 'derivation_id', 'id');
    }
    public function action_files()
    {
        return $this->hasMany(ActionFile::class, 'action_id', 'id');
    }
    public function resolutions()
    {
        return $this->belongsToMany(Resolution::class, 'related_resolutions', 'action_id', 'resolution_id');
    }
}
