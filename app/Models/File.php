<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class File extends Model
{
    protected $table = "files";
    protected $fillable = ['name', 'path'];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($file) {
            // Siempre generar un nuevo UUID durante la creación
            // independientemente de si ya hay un valor o no
            $file->attributes['uuid'] = self::uuidToBinary(Str::uuid());
        });
    }

    // Accessors y mutators
    public function getUuidAttribute($value)
    {
        if (!$value) return null;
        return self::binaryToUuid($value);
    }

    public function setUuidAttribute($value)
    {
        if ($value) {
            // Solo convertir si ya es un UUID en formato string
            if (is_string($value) && preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $value)) {
                $this->attributes['uuid'] = self::uuidToBinary($value);
            } else {
                $this->attributes['uuid'] = $value; // Asumimos que ya está en formato binario
            }
        }
    }

    // Métodos de utilidad
    public static function uuidToBinary($uuid)
    {
        return hex2bin(str_replace('-', '', (string) $uuid));
    }

    public static function binaryToUuid($binary)
    {
        if (!$binary) return null;
        $hex = bin2hex($binary);
        return vsprintf('%s-%s-%s-%s-%s', [
            substr($hex, 0, 8),
            substr($hex, 8, 4),
            substr($hex, 12, 4),
            substr($hex, 16, 4),
            substr($hex, 20, 12),
        ]);
    }

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
