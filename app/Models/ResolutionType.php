<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResolutionType extends Model
{
    protected $table = "resolution_types";
    protected $fillable = ['name'];
}
