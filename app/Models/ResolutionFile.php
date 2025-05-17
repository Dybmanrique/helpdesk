<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResolutionFile extends Model
{
    protected $table = "resolution_files";
    protected $fillable = ['resolution_id', 'file_id'];

    public function resolution()
    {
        return $this->belongsTo(Resolution::class, 'resolution_id', 'id');
    }

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }
}
