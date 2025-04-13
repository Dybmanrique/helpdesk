<?php

namespace App\Livewire\Admin\ProceduresOffice;

use App\Models\ActionFile;
use App\Models\Derivation;
use App\Models\Office;
use App\Models\Procedure;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class Crud extends Component
{
    use WithFileUploads;

    public $derivation;
    public $actions_select;
    public $expedient_number;
    public $office_id, $user_id;
    public $comment, $file;
    public $users = [];
    public $actions_map = [
        'Iniciar' => 'Se inició el trámite',
        'Comentar' => 'Se agregó un comentario',
        'Derivar' => 'Se derivó a otra oficina',
        'Concluir' => 'Se concluyó el trámite',
        'Anular' => 'Se anuló el trámite',
        'Archivar' => 'Se archivó el trámite',
    ];

    public $show_derivation_section = 'xd';

    public function setExpedientNumber(){
        $this->expedient_number = $this->generateExpedientNumber();
    }

    #[On('setSelectedDerivationId')] 
    public function handleSetSelectedDerivationId($id)
    {
        $derivation = Derivation::find($id);
        if($derivation){
            $this->derivation = $derivation;
        }
        $this->reset('actions_select', 'office_id', 'user_id', 'show_derivation_section', 'comment');
    }

    public function updatedActionsSelect()
    {
        $this->show_derivation_section = ($this->actions_select === 'derivar');
    }

    public function updatedOfficeId()
    {
        $this->users = User::whereHas('office', fn ($query) => 
            $query->where('id', $this->office_id)
        )->get();

        $this->user_id = ''; // Reiniciar selección
    }

    public function save(){
        $this->validate([
            'comment' => 'nullable|string|max:500',
            'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
        ]);

        $will_continue_active_derivation = 1;
        switch ($this->actions_select) {
            case 'derivar':
                $this->validate([
                    'office_id' => 'required|numeric',
                    'user_id' => 'required|numeric',
                    'comment' => 'nullable|string|max:500',
                    'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
                ]);
                $will_continue_active_derivation = 0;
                break;

            case 'comentar':
                $this->validate([
                    'comment' => 'required|string|max:500',
                    'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
                ]);
                $will_continue_active_derivation = 1;
                break;

            case 'concluir': 
            case 'anular': 
            case 'archivar':
                $this->validate([
                    'comment' => 'nullable|string|max:500',
                    'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,jpg,png'
                ]);
                $will_continue_active_derivation = 0;
                break;
            
            default:
                $will_continue_active_derivation = 1;
                break;
        }

        $action = $this->derivation->actions()->create([
            'action' => $this->actions_select,
            'comment' => $this->comment,
        ]);

        if($this->file){
            $extension = $this->file->extension();
            $folder = $extension === 'pdf' ? 'pdfs' : 'images';

            $path = $this->file->store('helpdesk/procedure_files/auth/' . $this->derivation->user->id . '/' . $folder);

            ActionFile::create([
                'name' => $this->file->getClientOriginalName(),
                'path' => $path,
                'action_id' => $action->id
            ]);
        }

        if($this->actions_select === 'derivar'){
            Derivation::create([
                'procedure_id' => $this->derivation->procedure->id,
                'user_id' => $this->user_id,
                'is_active' => 1
            ]);
        }

        $this->derivation->update([
            'is_active' => $will_continue_active_derivation
        ]);

        if($will_continue_active_derivation === 0){
            $this->dispatch('closeModal');
            $this->dispatch('refreshTable');
        }

        $this->dispatch('notify', ['message' => 'Hecho', 'code' => '200']);
        $this->reset('actions_select', 'office_id', 'user_id', 'show_derivation_section', 'comment', 'file');
    }

    private function generateExpedientNumber(): string
    {
        $year = now()->year;

        $lastProcedure = Procedure::whereYear('created_at', $year)->orderByDesc('created_at')->first();

        $lastNumber = 0;

        if ($lastProcedure && preg_match('/EXP-(\d+)-' . $year . '/', $lastProcedure->expedient_number, $matches)) {
            $lastNumber = (int) $matches[1];
        }

        $nextNumber = $lastNumber + 1;

        return 'EXP-' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT) . '-' . $year;
    }

    public function render()
    {
        $offices = Office::all();
        return view('livewire.admin.procedures-office.crud', compact('offices'));
    }
}
