<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = "persons";
    protected $fillable = ['nombre','apellido_paterno','apellido_materno','celular','direccion','dni'];

}
