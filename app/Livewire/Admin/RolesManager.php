<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

#[Layout('layouts.app')]
#[Title('Roles del Sistema')]
class RolesManager extends Component
{
    // Modal Create / Edit
    public bool $modalOpen = false;
    public ?int $editingId = null;
    public string $name = '';

    // Modal Delete
    public bool $deleteModalOpen = false;
    public ?int $deletingId = null;
    public string $deletingNombre = '';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . ($this->editingId ?? 'NULL') . ',id',
        ];
    }

    protected $messages = [
        'name.required' => 'El nombre del rol es obligatorio.',
        'name.unique' => 'Ya existe un rol con ese nombre.',
    ];

    public function openCreateModal()
    {
        abort_if(!auth()->user()->hasPermissionTo('roles.crear'), 403, 'Acceso denegado. No tienes permiso para crear roles.');
        $this->resetValidation();
        $this->editingId = null;
        $this->name = '';
        $this->modalOpen = true;
    }

    public function openEditModal(int $id)
    {
        abort_if(!auth()->user()->hasPermissionTo('roles.editar'), 403, 'Acceso denegado. No tienes permiso para editar roles.');
        $this->resetValidation();
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            session()->flash('error', 'No puedes modificar el rol principal del sistema.');
            return;
        }

        $this->editingId = $role->id;
        $this->name = $role->name;
        $this->modalOpen = true;
    }

    public function closeModal()
    {
        $this->modalOpen = false;
        $this->resetValidation();
        $this->dispatch('close-modal');
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            abort_if(!auth()->user()->hasPermissionTo('roles.editar'), 403, 'Acceso denegado. No tienes permiso para editar roles.');
            $role = Role::findOrFail($this->editingId);

            if ($role->name === 'admin') {
                session()->flash('error', 'No puedes modificar el rol principal del sistema.');
                $this->modalOpen = false;
                $this->dispatch('close-modal');
                return;
            }

            $role->update(['name' => strtolower(trim($this->name))]);
            session()->flash('success', 'Rol actualizado exitosamente.');
        } else {
            abort_if(!auth()->user()->hasPermissionTo('roles.crear'), 403, 'Acceso denegado. No tienes permiso para crear roles.');
            Role::create([
                'name' => strtolower(trim($this->name)),
                'guard_name' => 'web'
            ]);
            session()->flash('success', 'Rol creado exitosamente.');
        }

        $this->modalOpen = false;
        $this->dispatch('close-modal');
    }

    public function confirmDelete(int $id)
    {
        abort_if(!auth()->user()->hasPermissionTo('roles.eliminar'), 403, 'Acceso denegado. No tienes permiso para eliminar roles.');
        $role = Role::findOrFail($id);

        if ($role->name === 'admin') {
            session()->flash('error', 'No puedes eliminar el rol principal del sistema.');
            return;
        }

        if ($role->users()->count() > 0) {
            session()->flash('error', 'No puedes eliminar un rol que tiene usuarios asignados.');
            return;
        }

        $this->deletingId = $role->id;
        $this->deletingNombre = Str::title($role->name);
        $this->deleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->deleteModalOpen = false;
        $this->deletingId = null;
        $this->deletingNombre = '';
        $this->dispatch('close-modal');
    }

    public function delete()
    {
        abort_if(!auth()->user()->hasPermissionTo('roles.eliminar'), 403, 'Acceso denegado. No tienes permiso para eliminar roles.');
        if ($this->deletingId) {
            $role = Role::findOrFail($this->deletingId);

            if ($role->name === 'admin') {
                session()->flash('error', 'No puedes eliminar el rol principal del sistema.');
                $this->closeDeleteModal();
                return;
            }

            if ($role->users()->count() > 0) {
                session()->flash('error', 'No puedes eliminar un rol que tiene usuarios asignados.');
                $this->closeDeleteModal();
                return;
            }

            $role->delete();
            session()->flash('success', 'Rol eliminado exitosamente.');
        }

        $this->closeDeleteModal();
    }

    public function render()
    {
        abort_if(!auth()->user()->hasPermissionTo('roles.ver'), 403, 'Acceso denegado. No tienes permiso para ver roles.');

        $roles = Role::where('name', '!=', 'super-admin')->withCount(['users', 'permissions'])->orderBy('id')->get();

        return view('livewire.admin.roles-manager', [
            'roles' => $roles,
        ]);
    }
}
