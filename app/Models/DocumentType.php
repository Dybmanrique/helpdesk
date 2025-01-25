<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    protected $table = "document_types";
    protected $fillable = ['name'];

    public function procedures(){
        return $this->hasMany(Procedure::class,'document_type_id','id');
    }
}
