<?php

namespace App\Livewire\Admin\ProcedureCategories;

use App\Models\ProcedureCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class Crud extends Component
{
    public $document_type_id, $name;

    public function save(){
        $this->validate([
            'name' => 'required|string|max:255'
        ]);
        if($this->document_type_id){
            $documentType = ProcedureCategory::find($this->document_type_id);
            $documentType->update([
                'name' => $this->name
            ]);
        }else{
            ProcedureCategory::create([
                'name' => $this->name
            ]);
            $this->resetInputs();
        }
        $this->dispatch('notify', ['message' => 'Hecho', 'code' => '200']);
        $this->dispatch('refreshTable');
    }

    #[On('resetInputs')]
    public function resetInputs(){
        $this->document_type_id = null;
        $this->name = null;
    }

    #[On('deleteItem')] 
    public function delete($id)
    {
        ProcedureCategory::find($id)->delete();
        $this->dispatch('notify', ['message' => 'Hecho', 'code' => '200']);
        $this->dispatch('refreshTable');
    }

    #[On('editItem')] 
    public function edit($id, $name)
    {
        $this->document_type_id = $id;
        $this->name = $name;
    }

    public function render()
    {
        return view('livewire.admin.procedure-categories.crud');
    }
}
