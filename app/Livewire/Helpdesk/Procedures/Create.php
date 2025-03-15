<?php

namespace App\Livewire\Helpdesk\Procedures;

use App\Mail\ProcedureCreatedMail;
use App\Models\DocumentType;
use App\Models\File;
use App\Models\IdentityType;
use App\Models\LegalPerson;
use App\Models\Procedure;
use App\Models\ProcedureCategory;
use App\Models\ProcedurePriority;
use App\Models\ProcedureState;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;
    public $reason;
    public $description;
    public $procedureCategoryId;
    public $documentTypeId;
    public $files;

    public function render()
    {
        $identityTypes = IdentityType::all();
        $categories = ProcedureCategory::all();
        $documentTypes = DocumentType::all();
        $user = Auth::user();
        $legalPerson = LegalPerson::where('person_id', $user->person_id)->first();
        return view('livewire.helpdesk.procedures.create', compact('identityTypes', 'categories', 'documentTypes', 'user', 'legalPerson'));
    }

    public function save()
    {
        $this->validate([
            'reason' => 'required',
            'description' => 'required',
            'procedureCategoryId' => 'required',
            'documentTypeId' => 'required',
            'files' => 'nullable|mimes:jpg,jpeg,png,pdf|max:10240',
        ], [], [
            'reason' => 'asunto',
            'procedureCategoryId' => 'categoría',
            'documentTypeId' => 'tipo de documento',
        ]);
        $user = Auth::user();
        $procedureState = ProcedureState::where('name', 'Pendiente')->first();
        $procedurePriority = ProcedurePriority::where('name', 'Media')->first();
        if ($procedureState && $procedurePriority) {
            //registro del trámite
            $procedureTicket = $this->generateUniqueProcedureTicket();
            $procedure = Procedure::create([
                'reason' => $this->reason,
                'description' => $this->description,
                'ticket' => $procedureTicket,
                'procedure_priority_id' => $procedurePriority->id,
                'procedure_category_id' => $this->procedureCategoryId,
                'procedure_state_id' => $procedureState->id,
                'document_type_id' => $this->documentTypeId,
            ]);
            //registro de la relación del usuario con el trámite
            $user->procedures()->attach([$procedure->id]);

            //registro de los archivos del trámite
            if ($this->files) {
                $this->saveProcedureFiles($this->files, $user->id, $procedure);
            }
            //mandar el correo con la información del trámite registrado
            $emailErrorStatusMessage = $this->sendProcedureCreatedEmail($user->email, $procedure);

            //contenido de la alerta con la información del trámite registrado
            $emailStatusMessage = $emailErrorStatusMessage ?? "<span><b>Nota: </b>La información adicional fue enviada a su correo: <b>" . $user->email . "</b></span>";
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
        $this->reset(['reason', 'description', 'procedureCategoryId', 'documentTypeId', 'files']);
        $this->dispatch('resetInputs');
        $this->dispatch('notify', $notifyContent);
    }
    public function generateUniqueProcedureTicket()
    {
        do {
            $procedureTicket = Str::uuid(); // uuid
        } while (Procedure::where('ticket', $procedureTicket)->exists());
        return $procedureTicket;
    }
    public function saveProcedureFiles($file, $userId, Procedure $procedure)
    {
        $extension = $file->extension();
        $folder = $extension === 'pdf' ? 'pdfs' : 'images';
        File::create([
            'storage' => $file->store('helpdesk/procedure_files/auth/' . $userId . '/' . $folder),
            'procedure_id' => $procedure->id,
        ]);
    }
    public function sendProcedureCreatedEmail($email, Procedure $procedure)
    {
        try {
            Mail::to($email)->send(new ProcedureCreatedMail($procedure));
            $emailErrorStatusMessage = null;
        } catch (\Exception $e) {;
            $emailErrorStatusMessage = '<span style="color: #d33"><b>Nota: </b>Ocurrió un problema al enviar la información adicional a su correo: <b>' . $email . '</b></span>';
        }
        return $emailErrorStatusMessage;
    }
}
