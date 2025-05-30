<?php

namespace App\Livewire\Helpdesk\Procedures;

use App\Models\AdministrativeUser;
use App\Models\Derivation;
use App\Models\DocumentType;
use App\Models\IdentityType;
use App\Models\LegalPerson;
use App\Models\LegalRepresentative;
use App\Models\Office;
use App\Models\Person;
use App\Models\Procedure;
use App\Models\ProcedureCategory;
use App\Models\ProcedureCounter;
use App\Models\ProcedurePriority;
use App\Models\ProcedureState;
use App\Services\ProcedureService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class Create extends Component
{
    use WithFileUploads;
    public $user;
    public $legalPerson;
    public $procedureCategoryId = "", $documentTypeId = "", $reason, $description, $procedureFile, $procedureLink;
    public $search, $searchBy;
    public $applicant = [
        'isJuridical' => false,
        'name' => null,
        'lastName' => null,
        'secondLastName' => null,
        'email' => null,
        'phone' => null,
        'address' => null,
        'identityNumber' => null,
        'identityTypeId' => '',
        'ruc' => null,
        'companyName' => null,
    ];
    // public $applicantType = 0;
    public $currentStep = 1;

    public function mount()
    {
        $this->user = Auth::user();
        if ($this->user) {
            // Obtener la última empresa relacionada con el usuario autenticado
            $this->legalPerson = LegalRepresentative::where('person_id', $this->user->person_id)->latest()->first()?->legal_person;
        }
        $this->searchBy = IdentityType::first()->id;
    }

    public function render()
    {
        $identityTypes = IdentityType::all();
        $categories = ProcedureCategory::all();
        $documentTypes = DocumentType::all();
        return view('livewire.helpdesk.procedures.create', compact('identityTypes', 'categories', 'documentTypes'));
    }

    protected function rules()
    {
        $identityType = IdentityType::find($this->applicant['identityTypeId']);
        [$min, $max] = match ($identityType?->name) {
            'DNI' => [8, 8],
            'Carnet Extranjería' => [9, 12],
            default => [8, 12],
        };
        return [
            1 => [
                'applicant.isJuridical' => ['nullable', Rule::requiredIf(!Auth::check())],
                'applicant.name' => ['nullable', Rule::requiredIf(!Auth::check()), 'string'],
                'applicant.lastName' => ['nullable', Rule::requiredIf(!Auth::check()), 'string'],
                'applicant.secondLastName' => ['nullable', Rule::requiredIf(!Auth::check()), 'string'],
                'applicant.email' => ['nullable', Rule::requiredIf(!Auth::check()), 'string', 'lowercase', 'email', 'max:255', 'regex:/(.*)@(gmail\.com|hotmail\.com|outlook\.com|\.edu\.pe)$/i'],
                'applicant.phone' => ['nullable', Rule::requiredIf(!Auth::check()), 'numeric', 'digits:9'],
                'applicant.address' => ['nullable', Rule::requiredIf(!Auth::check()), 'string'],
                'applicant.identityNumber' => ['nullable', Rule::requiredIf(!Auth::check()), "between:$min,$max", 'regex:/^\d+$/'],
                'applicant.identityTypeId' => ['nullable', Rule::requiredIf(!Auth::check())],
                'applicant.ruc' => ['nullable', Rule::requiredIf(!Auth::check() && $this->applicant['isJuridical']), 'numeric', 'digits:11'],
                'applicant.companyName' => ['nullable', Rule::requiredIf(!Auth::check() && $this->applicant['isJuridical']), 'string'],
            ],
            2 => [
                'reason' => ['required'],
                'description' => ['required'],
                'procedureCategoryId' => ['required'],
                'documentTypeId' => ['required'],
            ],
            3 => [
                'procedureFile' => ['nullable', 'mimes:jpg,jpeg,png,pdf', 'max:10240'],
                'procedureLink' => ['nullable', 'url', 'regex:/^https:\/\/(drive\.google\.com\/(file\/d\/[\w-]+\/view|drive\/folders\/[\w-]+)\?usp=(sharing|drive_link)|[\w.-]+-my\.sharepoint\.com\/:([bf]):\/g\/personal\/[\w]+\/[\w-]+(\?e=[\w-]+)?)$/'],
            ],
        ];
    }

    protected function messages()
    {
        $identityType = IdentityType::find($this->applicant['identityTypeId']);
        return [
            'applicant.identityNumber.between' => match ($identityType?->name) {
                'DNI' => 'El número de identificación debe tener 8 dígitos.',
                'Carnet Extranjería' => 'El número de identificación debe tener entre 9 y 12 dígitos.',
                default => 'El número de identificación puede tener hasta 12 dígitos.',
            },
        ];
    }

    protected function attributes()
    {
        return [
            'applicant.name' => 'nombre',
            'applicant.lastName' => 'apellido paterno',
            'applicant.secondLastName' => 'apellido materno',
            'applicant.email' => 'email',
            'applicant.phone' => 'celular',
            'applicant.address' => 'dirección',
            'applicant.identityNumber' => 'número de identificación',
            'applicant.identityTypeId' => 'tipo de identidad',
            'applicant.ruc' => 'RUC',
            'applicant.companyName' => 'razón social',
            'reason' => 'asunto',
            'procedureCategoryId' => 'categoría',
            'documentTypeId' => 'tipo de documento',
            'procedureFile' => 'archivo',
            'procedureLink' => 'link del archivo',
        ];
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    #[On('applicantInformationConfirmed')]
    public function nextStep($isConfirmed = false)
    {
        $this->validate($this->rules()[$this->currentStep], $this->messages(), $this->attributes());
        if ($this->currentStep < 3) {
            if ($this->currentStep > 1 || $isConfirmed || Auth::check()) {
                $this->currentStep++;
            } elseif ($this->currentStep == 1 && !Auth::check()) {
                $changeDetectedMessages = $this->checkApplicantInformation();
                if ($changeDetectedMessages) {
                    $notifyContent = [
                        'title' => '¿Desea continuar con el proceso?',
                        'message' => '<p>Se han detectado posibles inconsistencias con sus datos de identificación:</p>
                                      <ul style="list-style-type: disc; list-style-position: inside; margin: 0.75rem 1rem;">' .
                            collect($changeDetectedMessages)->map(fn($msg) => "<li>{$msg}</li>")->implode('') .
                            '</ul><p><b>Nota:</b> Por favor verifique cuidadosamente los datos ingresados antes de continuar.</p>',
                    ];
                    $this->dispatch('confirmApplicantInformation', $notifyContent);
                } else {
                    $this->currentStep++;
                }
            }
        }
    }

    public function checkApplicantInformation()
    {
        // busco si hay registros de personas con el número de identidad ingresado
        $peopleQuery = Person::where('identity_number', $this->applicant['identityNumber']);
        $people = $peopleQuery->get();
        $changeDetectedMessages = [];
        if ($people->isNotEmpty()) {
            // busco en los registros de personas si hay coincidencias entre el número de identificación y el tipo de identificación
            // si no hay coincidencias puede haber seleccionado una opción erronea; debería notificarlo
            $peopleQuery->where('identity_type_id', $this->applicant['identityTypeId']);
            $personByIdentityType = $peopleQuery->get();
            if ($personByIdentityType->isNotEmpty()) {
                // busco en los registros de personas si hay alguna coincidencia con los apellidos y nombres ingresados
                // si hay coincidencias, es probable, que no haya errores por el usuario
                // si los datos no coinciden, podría ser un error del usuario, y, debería notificarlo
                $peopleQuery->where('name', $this->applicant['name'])
                    ->where('last_name', $this->applicant['lastName'])
                    ->where('second_last_name', $this->applicant['secondLastName']);
                $personByFullName = $peopleQuery->get();
                if ($personByFullName->isNotEmpty()) {
                    // en los registros coincidentes, busco si hay coincidencias con los datos de contacto
                    // si los datos de contacto no coinciden, pueden haber cambiado o ser error del usuario; debería notificarlo
                    $personByContactData = $peopleQuery->where('address', $this->applicant['address'])
                        ->where('phone', $this->applicant['phone'])
                        ->where('email', $this->applicant['email'])
                        ->first();
                    if (!$personByContactData) {
                        $changeDetectedMessages[] = 'Los datos de contacto no coinciden con los que se registraron previamente para esta persona.';
                    }
                } else {
                    $changeDetectedMessages[] = 'Los nombres y apellidos no coinciden con los de trámites previos asociados a este número de identificación.';
                }
            } else {
                $changeDetectedMessages[] = 'El tipo de identificación no coincide con el número de identificación de trámites previos asociados.';
            }
        }
        if ($this->applicant['isJuridical']) {
            $legalPersonQuery = LegalPerson::where('ruc', $this->applicant['ruc']);
            $legalPeople = $legalPersonQuery->get();
            if ($legalPeople->isNotEmpty()) {
                $legalPerson = $legalPersonQuery->where('company_name', $this->applicant['companyName'])->first();
                if (!$legalPerson) {
                    $changeDetectedMessages[] = 'La razón social no coincide con registros previos asociados a este número de RUC.';
                }
            }
        }
        return $changeDetectedMessages;
    }

    public function save(ProcedureService $procedureService)
    {
        $this->validate(collect($this->rules())->collapse()->toArray(), $this->messages(), $this->attributes());
        $procedureState = ProcedureState::where('name', 'Pendiente')->first();
        $procedurePriority = ProcedurePriority::where('name', 'Media')->first();
        if ($procedureState && $procedurePriority) {
            if (Auth::check()) {
                // si hay un usuario autenticado el solicitante es el usuario autenticado
                $applicant = Auth::user();
                $applicantEmail = $applicant->email;
            } else {
                // obtengo el solicitante (persona natural o representante legal) según los datos ingresados en el formulario
                // pero, primero lo busco, y, si no existe, lo registro (en personas y/o personas jurídicas, de ser el caso)
                $applicant = $this->findOrCreateApplicant($this->applicant);
                $applicantEmail = $this->applicant['email'];
            }
            // registro del trámite
            // obtener el siguiente número de expediente que se debe registrar
            $expedientNumber = $procedureService->getNextExpedientNumber();
            // generar el número del ticket
            $procedureTicket = $procedureService->generateUniqueProcedureTicket();
            $procedure = new Procedure([
                'expedient_number' => $expedientNumber,
                'reason' => $this->reason,
                'description' => $this->description,
                'ticket' => $procedureTicket,
                'is_juridical' => $this->applicant['isJuridical'],
                'year' => now()->year,
                'type' => 'external',
                'procedure_priority_id' => $procedurePriority->id,
                'procedure_category_id' => $this->procedureCategoryId,
                'procedure_state_id' => $procedureState->id,
                'document_type_id' => $this->documentTypeId,
            ]);
            $applicant->procedures()->save($procedure);

            // solo se debe registrar el archivo o el link del trámite; si existen ambos se registra solo el archivo
            if ($this->procedureFile) {
                //registro del archivo del trámite
                $procedureService->saveProcedureFiles($this->procedureFile, $applicant->id, $procedure);
            } elseif ($this->procedureLink) {
                //registro del link del trámite
                $procedureService->saveProcedureLink($this->procedureLink, $procedure);
            }

            // registrar la derivación del trámite a mesa de partes
            $procedureService->saveFirstProcedureDerivation($procedure);

            //mandar el correo con la información del trámite registrado
            $emailStatusMessage = $procedureService->sendProcedureCreatedEmail($applicantEmail, $procedure);

            //contenido de la alerta con la información del trámite registrado
            $notifyContent = [
                'title' => 'Trámite registrado correctamente',
                'message' => '<p>Su trámite fue registrado con el ticket: <br><b><code>' . $procedureTicket . '</code></b></p>
                            <p>' . $emailStatusMessage . '</p>',
                'code' => '201'
            ];
        } else {
            $notifyContent = ['message' => 'Algo salió mal. Inténtelo más tarde.', 'code' => '500'];
        }
        //reiniciar los inputs
        $this->reset(['applicant', 'reason', 'description', 'procedureCategoryId', 'documentTypeId', 'procedureFile', 'procedureLink', 'currentStep']);
        $this->dispatch('resetInputs');
        $this->dispatch('notify', $notifyContent);
    }

    public function findOrCreateApplicant($data)
    {
        // si los datos existen, se recupera el registro; si no, se crea uno nuevo
        $applicant = Person::firstOrCreate([
            'name' => $data['name'],
            'last_name' => $data['lastName'],
            'second_last_name' => $data['secondLastName'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'email' => $data['email'],
            'identity_number' => $data['identityNumber'],
            'identity_type_id' => $data['identityTypeId'],
        ]);
        if ($data['isJuridical']) {
            $legalPerson = LegalPerson::updateOrCreate(
                ['ruc' => $data['ruc']],
                ['company_name' => $data['companyName']],
            );
            $applicant = LegalRepresentative::firstOrCreate([
                'person_id' => $applicant->id,
                'legal_person_id' => $legalPerson->id,
            ]);
        }
        return $applicant;
    }

    public function searchPerson()
    {
        $this->validate([
            'applicant.identityNumber' => 'required',
            'applicant.identityTypeId' => 'required',
        ], [], [
            'applicant.identityNumber' => 'número de identificación',
            'applicant.identityTypeId' => 'tipo de identidad',
        ]);
        $person = Person::where('identity_number', $this->applicant['identityNumber'])
            ->where('identity_type_id', $this->applicant['identityTypeId'])->first();
        if ($person) {
            $this->applicant['identityTypeId'] = $person->identity_type_id;
            $this->applicant['identityNumber'] = $person->identity_number;
            $this->applicant['lastName'] = $person->last_name;
            $this->applicant['secondLastName'] = $person->second_last_name;
            $this->applicant['name'] = $person->name;
        } else {
            // $this->dispatch('resetApplicantInformationForm');
            $this->applicant['identityNumber'] = null;
            $this->applicant['lastName'] = null;
            $this->applicant['secondLastName'] = null;
            $this->applicant['name'] = null;
            $this->dispatch('notify', ['message' => 'No se encontraron resultados.', 'code' => '500']);
        }
    }

    public function searchLegalPerson()
    {
        $this->validate([
            'applicant.ruc' => 'required',
        ], [], [
            'applicant.ruc' => 'RUC',
        ]);
        $legalPerson = LegalPerson::where('ruc', $this->applicant['ruc'])->latest('updated_at')->first();
        if ($legalPerson) {
            $this->applicant['ruc'] = $legalPerson->ruc;
            $this->applicant['companyName'] = $legalPerson->company_name;
        } else {
            // $this->dispatch('resetApplicantInformationForm');
            $this->applicant['ruc'] = null;
            $this->applicant['companyName'] = null;
            $this->dispatch('notify', ['message' => 'No se encontraron resultados.', 'code' => '500']);
        }
    }
}
