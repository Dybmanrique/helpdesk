<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalPerson extends Model
{
    protected $table = "legal_persons";
    protected $fillable = ['ruc','razon_social','person_id'];

}
