<?php

namespace App\Livewire\AdminDashboard;

use Carbon\Carbon;
use App\Models\Major;
use App\Models\Classe;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;
use Livewire\Attributes\Validate;

class Classes extends Component
{
    use WithPagination;

    public $addingClasse = false;

    #[Validate('required', message: 'Veuillez entrer un nom pour la classe')]
    #[Validate('min:3', message: 'Le nom doit avoir au moins 3 caractères')]
    #[Validate('max:25', message: 'Le nom doit avoir au plus 25 caractères')]
    public $newClasseName;

    #[Validate('required', message: 'Veuillez choisir une filière pour la classe')]
    public $newClasseFil;

    #[Validate('required', message: "Veuillez saisir l'année scolaire")]
    public $newAnneeScolaire;

    public $search = '';
    public $filter_dep = '';
    public $filter_fil = '';


    public function render()
    {

        // Start with the base query
        // $classes = Classe::query();
        $classes = Classe::withCount('students');


        // Apply the major filter if selected
        if (!empty($this->filter_fil)) {
            $classes->where('major_id', $this->filter_fil);
        }

        // Apply the department filter if selected
        if (!empty($this->filter_dep)) {
            $department = Department::find($this->filter_dep);
            if ($department) {
                $majorIds = $department->majors->pluck('id');
                $classes->whereIn('major_id', $majorIds);
            }
        }

        // Apply the search filter
        if (!empty($this->search)) {
            $classes->where('name', 'like', "%{$this->search}%");
        }

        // Paginate the results
        $classes = $classes->latest()->paginate(10);
        // dd($classes[5]->students_count);
        return view('livewire.admin-dashboard.classes', [
            'classes' => $classes,
            'departements' => Department::all(),
            'filieres' => Major::all(),
        ]);
    }

    public function addClasse() {
        $this->validateOnly('newClasseName');
        $this->validateOnly('newClasseFil');
        try {
            Classe::create([
                'name' => $this->newClasseName,
                'major_id' => $this->newClasseFil,
                'school_year' => $this->newAnneeScolaire,
            ]);
        } catch (\Throwable $th) {
            session()->flash('danger','Une erreur est servenu');
            throw $th;
        }
        $this->reset('newClasseName');
        $this->reset('newClasseFil');
        $this->reset('newAnneeScolaire');
        $this->reset('addingClasse');
        session()->flash('success','Classe a bien été ajoutée');
    }
}
