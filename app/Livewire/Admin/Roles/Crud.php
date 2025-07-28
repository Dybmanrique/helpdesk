<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Attributes\On;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Crud extends Component
{
    public $id, $name, $groupedPermissions;
    public $selectedPermissions = [];

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $this->id,
            'selectedPermissions' => 'required',
        ], [], [
            'selectedPermissions' => 'permisos',
        ]);
        if ($this->id) {
            $role = Role::find($this->id);
            $role->update([
                'name' => $this->name
            ]);
            $role->permissions()->sync($this->selectedPermissions);
        } else {
            $role = Role::create([
                'name' => $this->name
            ]);
            $role->permissions()->sync($this->selectedPermissions);
            $this->resetInputs();
        }
        $this->dispatch('notify', ['message' => 'Hecho', 'code' => '200']);
        $this->dispatch('refreshTable');
    }

    #[On('resetInputs')]
    public function resetInputs()
    {
        $this->id = null;
        $this->name = null;
        $this->selectedPermissions = [];
        $this->resetValidation();
    }

    #[On('deleteItem')]
    public function delete($id)
    {
        Role::find($id)->delete();
        $this->dispatch('notify', ['message' => 'Hecho', 'code' => '200']);
        $this->dispatch('refreshTable');
    }

    #[On('editItem')]
    public function edit($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
        $role = Role::find($this->id);
        $this->selectedPermissions = $role->permissions->pluck('id');
    }

    public function mount()
    {
        $permissions = Permission::select('id', 'name')->orderBy('name', 'asc')->get();
        $groupedPermissions = $permissions->map(function ($item, $key) {
            $permission = explode(':', $item->name);
            return [
                'group' => $permission[0],
                'permission' => [
                    'id' => $item->id,
                    'name' => trim($permission[1]),
                ],
            ];
        });
        $this->groupedPermissions = collect($groupedPermissions)->groupBy('group');
    }

    public function render()
    {
        return view('livewire.admin.roles.crud');
    }
}
