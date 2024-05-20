<?php

namespace App\Livewire\AdminDashboard;

use App\Models\User;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\Attributes\Validate;

class AddEditProfesseur extends Component
{
    public $UserTeacherId;
    public $professeur;
    public $isEditing = false;

    #[Validate('required|min:6|max:20')]
    public $name;

    #[Validate('required|min:10|max:10')]
    public $CIN;


    public $diplome;


    public $phone;

    #[Validate('required|email')]
    public $email;

    #[Validate('required|password')]
    public $password;

    public function add()
    {
        return view('livewire.admin-dashboard.add-edit-professeur');
    }

    public function edit($id)
    {
        $this->isEditing = true;
        $this->professeur = Teacher::where('user_id', $id)->firstOrFail();
        $this->UserTeacherId = $id;
        $this->name = 'Ibrahim Bensaadoune';
        $this->phone = $this->professeur->user->phone;
        $this->email = $this->professeur->user->email;
        $this->password = $this->professeur->user->password;
        $this->CIN = $this->professeur->CIN;
        $this->diplome = $this->professeur->diplome;
        // $this->save();
        return view('livewire.admin-dashboard.add-edit-professeur', [
            'professeur' => $this->professeur,
        ]);
    }

    public function save()
    {
        // $this->validate();
        User::find($this->UserTeacherId)->update([
            'name'=> $this->name,
            'phone'=> $this->phone,
            'email'=> $this->email,
            'password'=> $this->password,
        ]);
        Teacher::where('user_id', $this->UserTeacherId)->firstOrFail()->update([
            'CIN' => $this->CIN,
            'diplome' => $this->diplome,
        ]);

        session()->flash('ProfesseurUpdated', " Professeur updated successfely");
    }

}
