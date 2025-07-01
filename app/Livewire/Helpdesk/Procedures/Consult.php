<?php

namespace App\Livewire\Helpdesk\Procedures;

use App\Models\LegalRepresentative;
use App\Models\Person;
use App\Models\Procedure;
use App\Models\User;
use Livewire\Component;

class Consult extends Component
{
    public $search;
    public $searchBy = "expedientNumber";
    public $procedure;
    public $applicant = [
        'type' => null,
        'name' => null,
        'email' => null,
        'identityNumber' => null,
        'identityType' => null,
        'ruc' => null,
        'companyName' => null,
    ];
    public $derivations;
    public $allProcedureDerivations;
    public $derivationsToShow = 5;

    public function render()
    {
        return view('livewire.helpdesk.procedures.consult');
    }

    public function searchProcedure()
    {
        $this->validate([
            'search' => 'required',
        ], [], [
            'search' => 'buscar trámite',
        ]);
        // construcción del query para precargar todos los datos necesarios y relacionados al trámite
        $procedureQuery = [
            'applicant' => function ($morphTo) {
                $morphTo->morphWith([
                    Person::class => ['identity_type:id,name'],
                    LegalRepresentative::class => ['person:id,name,last_name,second_last_name,email,identity_number,identity_type_id', 'person.identity_type:id,name', 'legal_person:id,company_name,ruc'],
                    User::class => ['person:id,name,last_name,second_last_name,email,identity_number,identity_type_id', 'person.identity_type:id,name'],
                ]);
            },
            'state:id,name',
            'document_type:id,name',
            'category:id,name',
            'derivations:id,procedure_id,user_id,office_id,created_at',
            'derivations.user:id,person_id',
            'derivations.user.person:id,name,last_name,second_last_name',
            'derivations.office:id,name',
            'derivations.actions:id,action,comment,derivation_id,created_at',
            'derivations.actions.action_files:id,name,action_id',
            'derivations.actions.resolutions:id,resolution_number,description,resolution_state_id,resolution_type_id',
            'derivations.actions.resolutions.resolution_state:id,name',
            'derivations.actions.resolutions.resolution_type:id,name',
            'derivations.actions.resolutions.file_resolution:id,name,resolution_id',
        ];
        if ($this->searchBy === "ticket") {
            $this->procedure = Procedure::with($procedureQuery)->where('ticket', $this->search)->first();
        } elseif ($this->searchBy === "expedientNumber") {
            $this->procedure = Procedure::with($procedureQuery)->where('expedient_number', $this->search)->first();
        }
        if ($this->procedure) {
            // obtener la información del solicitante de la relación polimórfica
            $procedureApplicant = $this->procedure->applicant;
            $legalPerson = null;
            if ($procedureApplicant instanceof Person) {
                $person = $procedureApplicant;
                $this->applicant['type'] = 'Persona Natural';
                $this->applicant['email'] = $person->email;
            } elseif ($procedureApplicant instanceof LegalRepresentative) {
                $person = $procedureApplicant->person;
                $legalPerson = $procedureApplicant->legal_person;
                $this->applicant['type'] = 'Persona Jurídica';
                $this->applicant['email'] = $person->email;
            } elseif ($procedureApplicant instanceof User) {
                $person = $procedureApplicant->person;
                $this->applicant['type'] = 'Persona Natural';
                $this->applicant['email'] = $procedureApplicant->email; // el correo será tomado del usuario
                if ($this->procedure->is_juridical) {
                    // obtener la última persona jurídica relacionada con la persona
                    $legalRepresentative = LegalRepresentative::where('person_id', $person->id)->latest('updated_at')->first();
                    $legalPerson = $legalRepresentative->legal_person;
                    $this->applicant['type'] = 'Persona Jurídica';
                }
            }
            $this->applicant['name'] = $person->full_name;
            $this->applicant['identityType'] = $person->identity_type->name;
            $this->applicant['identityNumber'] = $person->identity_number;
            $this->applicant['ruc'] = $legalPerson?->ruc;
            $this->applicant['companyName'] = $legalPerson?->company_name;

            // crear un array con los datos que se van a mostrar en las derivaciones
            $this->allProcedureDerivations = $this->procedure->derivations->map(function ($derivation, $i) {
                // cada derivación solo guarda la información del destino de la derivación
                if ($i === 0) {
                    // si es la primera iteración, los datos del origen de la derivación se indican manualmente
                    $fromUser = $this->applicant['name'];
                    $fromOffice = 'Solicitante';
                    $state = 'Registrado';
                } else {
                    // si no es la primera iteración, los datos del origen de la derivación se toman de la derivación anterior
                    $fromUser = $this->procedure->derivations[$i - 1]->user->person->full_name;
                    $fromOffice = $this->procedure->derivations[$i - 1]->office->name;
                    $state = $derivation->actions->last()->action ?? '';
                }
                $toUser = $derivation->user->person->full_name;
                $toOffice = $derivation->office->name;
                return [
                    'date' => $derivation->created_at->format('d-m-Y'),
                    'fromUser' => $fromUser,
                    'fromOffice' => $fromOffice,
                    'toUser' => $toUser,
                    'toOffice' => $toOffice,
                    'state' => $state,
                    'actions' => $derivation->actions,
                ];
            });
            // cargar los datos de las derivaciones
            $this->loadDerivations();
            $notify_content = ['message' => 'Trámite encontrado.', 'code' => '200'];
        } else {
            $notify_content = ['message' => 'El trámite no fue encontrado.', 'code' => '500'];
        }
        return $this->dispatch('notify', $notify_content);
    }

    public function loadDerivations()
    {
        // cargar las derivaciones hasta el valor que tiene derivationsToShow
        $this->derivations = $this->allProcedureDerivations->take($this->derivationsToShow);
    }

    public function loadMoreDerivations()
    {
        // actualizo el limite de derivaciones para mostrar
        $this->derivationsToShow += 3;
        $this->loadDerivations();
    }
}
