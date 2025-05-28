<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProcedureFile extends Model
{
    protected $table = "procedure_files";
    protected $fillable = ['name', 'path', 'uuid', 'procedure_id'];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class, 'procedure_id', 'id');
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
