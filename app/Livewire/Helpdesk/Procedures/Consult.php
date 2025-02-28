<?php

namespace App\Livewire\Helpdesk\Procedures;

use App\Models\LegalPerson;
use App\Models\Procedure;
use Livewire\Component;

class Consult extends Component
{
    public $ticket;
    public $procedure;
    public $user;
    public $person;
    public $legal_person;

    public function mount($ticket = null)
    {
        $this->ticket = $ticket;
        if ($this->ticket) {
            $this->search();
        }
    }

    public function search()
    {
        $this->procedure = Procedure::where('ticket', $this->ticket)->first();
        if ($this->procedure) {
            $this->user = $this->procedure->users->first();
            if ($this->user) {
                $this->person = $this->user->person;
                $this->legal_person = LegalPerson::where('person_id', $this->person->id)->first();
                $notify_content = ['message' => 'Trámite encontrado.', 'code' => '200'];
            } else {
                $notify_content = ['message' => 'Algo salió mal. Inténtelo más tarde.', 'code' => '500'];
            }
        } else {
            $notify_content = ['message' => 'Algo salió mal. Inténtelo más tarde.', 'code' => '500'];
        }
        return $this->dispatch('notify', $notify_content);
    }

    public function render()
    {
        return view('livewire.helpdesk.procedures.consult');
    }

    public function searchTicket()
    {
        $this->validate([
            'ticket' => 'required',
        ], [], [
            'ticket' => 'código del trámite',
        ]);
        if ($this->ticket) {
            // Actualizar la URL sin usar query string para mantener la URL limpia
            $this->redirect(route('procedures.consult', ['code' => $this->ticket]), navigate: true);
        }
    }
}
