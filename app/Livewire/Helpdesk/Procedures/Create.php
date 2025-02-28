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
    public $procedure_category_id;
    public $procedure_priority_id;
    public $document_type_id;
    public $files;
    
    public function render()
    {
        $identity_types = IdentityType::all();
        $priorities = ProcedurePriority::all();
        $categories = ProcedureCategory::all();
        $document_types = DocumentType::all();
        $user = Auth::user();
        $legal_person = LegalPerson::where('person_id', $user->person_id)->first();
        return view('livewire.helpdesk.procedures.create', compact('identity_types', 'priorities', 'categories', 'document_types', 'user', 'legal_person'));
    }

    public function save()
    {
        $this->validate([
            'reason' => 'required',
            'description' => 'required',
            'procedure_category_id' => 'required',
            'procedure_priority_id' => 'required',
            'document_type_id' => 'required',
            'files' => 'required|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);
        $user = Auth::user();
        $procedure_state = ProcedureState::where('name', 'Pendiente')->first();
        if ($procedure_state) {
            //registro del trámite
            $procedure_ticket = $this->generateUniqueProcedureTicket();
            $procedure = Procedure::create([
                'reason' => $this->reason,
                'description' => $this->description,
                'ticket' => $procedure_ticket,
                'procedure_priority_id' => $this->procedure_priority_id,
                'procedure_category_id' => $this->procedure_category_id,
                'procedure_state_id' => $procedure_state->id,
                'document_type_id' => $this->document_type_id,
            ]);
            //registro de la relación del usuario con el trámite
            $user->procedures()->attach([$procedure->id]);
            //registro de los archivos del trámite
            if ($this->files) {
                File::create([
                    'storage' => $this->files->store('helpdesk/procedure_files'),
                    'procedure_id' => $procedure->id,
                ]);
            }
            //generar un pdf con la información del trámite registrado

            //mandar el correo con la información del trámite registrado
            // Mail::to($user->email)->send(new ProcedureCreatedMail($procedure));
            $this->sendProcedureCreatedEmail($user->email, $procedure);
            
            //mostrar la alerta con la información del trámite registrado
            $notify_content = [
                'title' => 'Trámite registrado correctamente',
                'message' => '<p>Su trámite fue registrado con el ticket: <b>' . $procedure_ticket . '</b></p>
                                <p>El cargo del trámite fue enviado al correo: <b>' . $user->email . '</b></p>',
                'code' => '201'
            ];
        } else {
            $notify_content = ['message' => 'Algo salió mal. Inténtelo más tarde.', 'code' => '500'];
        }
        //reiniciar los inputs
        $this->reset(['reason', 'description', 'procedure_category_id', 'procedure_priority_id', 'document_type_id', 'files']);
        $this->dispatch('resetInputs');
        return $this->dispatch('notify', $notify_content);
    }
    public function generateUniqueProcedureTicket()
    {
        do {
            $procedure_ticket = Str::random(10); // uuid
        } while (Procedure::where('ticket', $procedure_ticket)->exists());
        return $procedure_ticket;
    }
    public function sendProcedureCreatedEmail($email, Procedure $procedure)
    {
        Mail::to($email)->send(new ProcedureCreatedMail($procedure)); // envio del email en segundo plano
    }
}
