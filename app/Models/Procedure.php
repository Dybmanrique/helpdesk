<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $table = "procedures";
    protected $fillable = ['expedient_number','reason','description','ticket','is_juridical','procedure_priority_id','procedure_category_id','procedure_state_id','document_type_id'];
    
    public function document_type(){
        return $this->belongsTo(DocumentType::class,'document_type_id','id');
    }
    public function procedure_category(){
        return $this->belongsTo(ProcedureCategory::class,'procedure_category_id','id');
    }
    public function procedure_priority(){
        return $this->belongsTo(ProcedurePriority::class,'procedure_priority_id','id');
    }
    public function procedure_state(){
        return $this->belongsTo(ProcedureState::class,'procedure_state_id','id');
    }
    public function files(){
        return $this->hasMany(File::class,'procedure_id','id');
    }
    public function derivations(){
        return $this->hasMany(Derivation::class,'procedure_id','id');
    }
    public function comments(){
        return $this->hasMany(Comment::class,'procedure_id','id');
    }
    public function people(){
        return $this->belongsToMany(Person::class,'procedure_person','procedure_id','person_id');
    }
    public function users(){
        return $this->belongsToMany(User::class,'for_knowledge','procedure_id','user_id');
    }
    public function user()
    {
        return $this->hasOneThrough(User::class, ForKnowledge::class, 'procedure_id', 'user_id', 'id', 'id');
    }
}
