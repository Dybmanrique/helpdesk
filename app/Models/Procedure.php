<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $table = "procedures";
    protected $fillable = [
        'expedient_number',
        'reason',
        'description',
        'ticket',
        'is_juridical',
        'year',
        'type',
        'procedure_priority_id',
        'procedure_category_id',
        'procedure_state_id',
        'document_type_id',
        'user_id',
        'applicant_full_name',
        'applicant_identification',
        'company_ruc',
    ];

    public function document_type()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id', 'id');
    }
    public function category()
    {
        return $this->belongsTo(ProcedureCategory::class, 'procedure_category_id', 'id');
    }
    public function priority()
    {
        return $this->belongsTo(ProcedurePriority::class, 'procedure_priority_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(ProcedureState::class, 'procedure_state_id', 'id');
    }
    public function procedure_link()
    {
        return $this->hasOne(ProcedureLink::class, 'procedure_id', 'id');
    }
    public function procedure_files()
    {
        return $this->hasMany(ProcedureFile::class, 'procedure_id', 'id');
    }
    public function derivations()
    {
        return $this->hasMany(Derivation::class, 'procedure_id', 'id');
    }
    public function users_for_knowledge()
    {
        return $this->belongsToMany(User::class, 'for_knowledge', 'procedure_id', 'user_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function actions()
    {
        return $this->hasManyThrough(
            Action::class,
            Derivation::class,
            'procedure_id', // Foreign key en la tabla `derivations`
            'derivation_id', // Foreign key en la tabla `actions`
            'id', // Local key en `procedures`
            'id'  // Local key en `derivations`
        )->orderBy('created_at', 'desc');;
    }
    public function applicant()
    {
        return $this->morphTo();
    }
}
