<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resolution extends Model
{
    protected $table = "resolutions";
    protected $fillable = ['resolution_number', 'description', 'user_id', 'resolution_type_id', 'resolution_state_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function resolution_type()
    {
        return $this->belongsTo(ResolutionType::class, 'resolution_type_id', 'id');
    }
    public function resolution_state()
    {
        return $this->belongsTo(ResolutionState::class, 'resolution_state_id', 'id');
    }
    public function file_resolution()
    {
        return $this->hasOne(ResolutionFile::class);
    }
    public function actions()
    {
        return $this->belongsToMany(Action::class, 'related_resolutions', 'resolution_id', 'action_id');
    }
}
