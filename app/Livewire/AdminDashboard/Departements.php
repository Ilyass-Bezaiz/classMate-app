<?php

namespace App\Livewire\AdminDashboard;

use Livewire\Component;
use App\Models\Department;
use App\Livewire\ToastMessage;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;


class Departements extends Component
{

    public $addingDep =false;
    public $deletingDep =false;

    public $editingDepId;
    public $deletingDepId;

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $adminPassword;

    #[Validate('required', message: 'Veuillez entrer un nom pour la département')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $editingDepName;

    #[Validate('required', message: 'Veuillez entrer un nom pour la département')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $newDepName;

    public $search = '';

    public function render()
    {
        $departements = Department::withCount('majors');

        // Apply the search filter
        if (!empty($this->search)) {
            $departements->where('name', 'like', "%{$this->search}%");
        }

        return view('livewire.admin-dashboard.departements',[
            'departements' => $departements->get(),
        ]);
    }


    public function add()
    {
        $validated = $this->validateOnly('newDepName');
        try {
            Department::create([
                'name' => $this->newDepName,
            ]);
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
        $this->reset('newDepName');
        $this->reset('addingDep');
        Toaster::success('Département a bien été ajoutée');
    }

    public function update()
    {
        $this->validateOnly('editingDepName');
        try {
            Department::find($this->editingDepId)->update([
                'name'=> $this->editingDepName,
            ]);
            $this->cancelEdit();
            Toaster::success('Département a bien été modifiée');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function delete()
    {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                Department::find($this->deletingDepId)->delete();
                $this->cancelDeleting();
                Toaster::success('Département a bien été supprimeée');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }

        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function cancelDeleting()
    {
        $this->reset('deletingDep', 'deletingDepId');
    }

    public function cancelEdit() {
        $this->reset('editingDepId', 'editingDepName');
    }
}
