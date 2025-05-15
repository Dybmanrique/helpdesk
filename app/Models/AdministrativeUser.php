<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrativeUser extends Model
{
    protected $table = "administrative_users";
    protected $fillable = ['user_id','office_id', 'is_default'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function office(){
        return $this->belongsTo(Office::class);
    }
}
