<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureLink extends Model
{
    protected $table = "procedure_links";
    protected $fillable = ['url', 'procedure_id'];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class, 'procedure_id', 'id');
    }
}
