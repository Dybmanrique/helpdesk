<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdministrativeUser extends Model
{
    protected $table = "administrative_users";
    protected $fillable = ['user_id','office_id'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function office(){
        return $this->belongsTo(Office::class,'office_id','id');
    }
}
