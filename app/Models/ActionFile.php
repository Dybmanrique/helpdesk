<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ActionFile extends Model
{
    protected $table = "action_files";
    protected $fillable = ['name', 'path', 'name', 'uuid', 'action_id'];

    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($file) {
            // Siempre generar un nuevo UUID durante la creación
            // independientemente de si ya hay un valor o no
            $file->attributes['uuid'] = (Str::uuid());
        });
    }
}
