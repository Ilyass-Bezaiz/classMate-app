<?php

namespace App\Livewire\StudentDashboard;

use App\Events\NotificationSent;
use App\Models\Student;
use Livewire\Component;
use App\Models\Notification;
use Masmerise\Toaster\Toaster;

class StudentNotification extends Component
{
    public $student;
    public $notifications;
    public $allSeen;
    public function mount()
    {
        $this->student = Student::where('user_id', auth()->user()->id)->first();
        $this->notifications = Notification::where('receiver_id', $this->student->id)->orderByDesc('created_at')->get();
        $this->allSeen = true;
        foreach ($this->notifications as $notif) {
            $notif->read ? $notif : $this->allSeen = false;
        }
    }

    public function getListeners()
    {
        return [
            "echo-private:notifications.{$this->student->id},NotificationSent" => 'refreshNotifications',
        ];
    }
    public function refreshNotifications()
    {
        $this->notifications = Notification::where('receiver_id', $this->student->id)->orderByDesc('created_at')->get();
        $this->allSeen = true;
        foreach ($this->notifications as $notif) {
            $notif->read ? $notif : $this->allSeen = false;
        }
        Toaster::info('Vous avez une nouvelle notification');
    }

    public function markAllAsRead()
    {
        foreach ($this->notifications as $notif) {
            $notif->update([
                'read' => true,
            ]);
            $this->allSeen = true;
        }
    }

    public function markAsRead($id)
    {
        $notif = Notification::find($id);
        $notif->update([
            'read' => true,
        ]);
        $this->mount();
    }
    public function render()
    {
        return view(
            'livewire.student-dashboard.student-notification'
        );
    }
}
