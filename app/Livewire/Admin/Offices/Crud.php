<?php

namespace App\Livewire\Admin\Offices;

use App\Models\Office;
use Livewire\Attributes\On;
use Livewire\Component;

class Crud extends Component
{
    public $id, $name, $description;

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1255',
        ]);
        if($this->id){
            $documentType = Office::find($this->id);
            $documentType->update([
                'name' => $this->name,
                'description' => $this->description,
            ]);
        }else{
            Office::create([
                'name' => $this->name,
                'description' => $this->description,
            ]);
            $this->resetInputs();
        }
        $this->dispatch('notify', ['message' => 'Hecho', 'code' => '200']);
        $this->dispatch('refreshTable');
    }

    #[On('resetInputs')]
    public function resetInputs(){
        $this->id = null;
        $this->name = null;
        $this->description = null;
    }

    #[On('deleteItem')] 
    public function delete($id)
    {
        Office::find($id)->delete();
        $this->dispatch('notify', ['message' => 'Hecho', 'code' => '200']);
        $this->dispatch('refreshTable');
    }

    #[On('editItem')] 
    public function edit($id, $name, $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function render()
    {
        return view('livewire.admin.offices.crud');
    }
}
