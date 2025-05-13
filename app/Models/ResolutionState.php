<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResolutionState extends Model
{
    protected $table = "resolution_states";
    protected $fillable = ['name'];
}
