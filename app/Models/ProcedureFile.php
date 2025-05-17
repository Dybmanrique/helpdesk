<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureFile extends Model
{
    protected $table = "procedure_files";
    protected $fillable = ['procedure_id', 'file_id'];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class, 'procedure_id', 'id');
    }
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id', 'id');
    }
}
