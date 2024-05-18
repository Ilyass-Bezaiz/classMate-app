<?php

namespace App\Livewire\AdminDashboard;

use App\Models\Classe;
use App\Models\Major;
use Livewire\Component;
use App\Models\Department;
use Livewire\WithPagination;

class Classes extends Component
{
    use WithPagination;

    public $search = '';
    public $filter_dep = '';
    public $filter_fil = '';

    // public function mount()
    // {

    // }

    public function render()
    {
        // $classes = Classe::latest();
        // if (!empty($this->filter_fil)) {
        //     // dd($this->filter_dep);
        //     $classes = $classes->where('major_id', $this->filter_fil);
        // }
        // if (!empty($this->filter_dep)) {
        //     // dd($this->filter_dep);
        //     $deprt = Department::find($this->filter_dep);
        //     foreach ($deprt->majors as $major) {
        //         # code...
        //         dump($major->classes);
        //         // $classes.=
        //     }
        //     dump($classes);
        // }
        // return view(
        //     'livewire.admin-dashboard.classes',
        //     [
        //         'classes' => $classes->latest()->where('name', 'like', "%{$this->search}%")->paginate(10),
        //         'departements' => Department::all(),
        //         'filieres' => Major::all(),
        //     ]
        // );

        // Start with the base query
        $classes = Classe::query();

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

        return view('livewire.admin-dashboard.classes', [
            'classes' => $classes,
            'departements' => Department::all(),
            'filieres' => Major::all(),
        ]);
    }
}
