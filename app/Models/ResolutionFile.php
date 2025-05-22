<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ResolutionFile extends Model
{
    protected $table = "resolution_files";
    protected $fillable = ['name', 'uuid', 'path', 'resolution_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($file) {
            // Siempre generar un nuevo UUID durante la creación
            // independientemente de si ya hay un valor o no
            $file->attributes['uuid'] = (Str::uuid());
        });
    }

    public function resolution()
    {
        return $this->belongsTo(Resolution::class, 'resolution_id', 'id');
    }

}
