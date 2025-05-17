<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Derivation extends Model
{
    protected $table = "derivations";
    protected $fillable = ['is_active', 'procedure_id', 'user_id', 'office_id'];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class, 'procedure_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function actions()
    {
        return $this->hasMany(Action::class);
    }
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
}
