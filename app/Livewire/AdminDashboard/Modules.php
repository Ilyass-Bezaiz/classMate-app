<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Major;
use App\Models\Module;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Modules extends Component
{
    public $addingModule = false;
    public $deletingMod = false;

    public $editingModId;
    public $deletingModId;

    #[Validate('required', message: "Veuillez saisir votre mot de passe")]
    public $adminPassword;

    #[Validate('required', message: 'Veuillez entrer un nom pour le module')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $newModName;

    #[Validate('required', message: 'Veuillez entrer un nom pour le module')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:50', message: 'Le nom doit avoir au plus 50 caractères')]
    public $editingModName;

    #[Validate('required', message: 'Veuillez entrer un nom pour le module')]
    public $editingModFiliere;

    #[Validate('required', message: 'Veuillez selectionner une filière du module')]
    public $newModFiliere;

    public $search;
    public $filter_fil;

    public function render()
    {
        $modules = Module::with('major');


        // Apply the search filter
        if (!empty($this->search)) {
            $modules->where('name', 'like', "%{$this->search}%");
        }

        // Apply the major filter if selected
        if (!empty($this->filter_fil)) {
            $major = Major::find($this->filter_fil);
            if ($major) {
                $modules->where('major_id', $major->id);
            }
        }

        return view('livewire.admin-dashboard.modules', [
            'modules' => $modules->get(),
            'filieres' => Major::all(),
        ]);
    }

    public function addModule()
    {
        $this->validateOnly('newModName');
        $this->validateOnly('newModFiliere');
        try {
            Module::create([
                'name' => $this->newModName,
                'major_id' => $this->newModFiliere,
            ]);
            $this->reset('newModName', 'addingModule');
            Toaster::success('Module a bien été ajoutée');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

    public function updateModule()
    {
        $this->validateOnly('editingModName');
        $this->validateOnly('editingModFiliere');
        try {
            Module::find($this->editingModId)->update([
                'name' => $this->editingModName,
               'major_id' => $this->editingModFiliere,
            ]);
            $this->reset('editingModName', 'editingModFiliere', 'editingModId');
            Toaster::success('Module a bien été modifiée');
        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
        }
    }

    public function delete()
    {
        $user = Auth::user();
        $this->validateOnly('adminPassword');
        try {
            if (password_verify($this->adminPassword, $user->password)) {
                Module::find($this->deletingModId)->delete();
                $this->reset('deletingMod', 'adminPassword', 'deletingModId');
                Toaster::success('Module a bien été supprimeée');
            } else {
                $this->addError('adminPassword', 'Le mot de passe est incorrect.');
            }

        } catch (\Throwable $th) {
            Toaster::error('Une erreur est servenu');
            throw $th;
        }
    }

}
