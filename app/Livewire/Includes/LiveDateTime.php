<?php

namespace App\Livewire\Includes;

use Carbon\Carbon;
use Livewire\Component;

class LiveDateTime extends Component
{
    public $currentDate;
    public $currentTime;

    public function mount()
    {
        $this->updateDateTime();
    }

    public function updateDateTime()
    {
        // Set locale to French
        setlocale(LC_TIME, 'fr_FR.utf8');
        $this->currentDate = Carbon::now()->locale('fr_FR')->isoFormat('dddd D MMMM YYYY');
        $this->currentTime = Carbon::now()->locale('fr_FR')->isoFormat('HH:mm:ss');
    }

    public function render()
    {
        return view('livewire.includes.live-date-time');
    }

}
