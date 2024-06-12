<?php

namespace App\Models;

use App\Events\NotificationSent;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'receiver_id', 'message', 'read'];

    protected static function booted()
    {
        static::created(function ($notification) {
            Event::dispatch(new NotificationSent($notification));
        });
    }
    public function sender()
    {
        return $this->belongsTo(Teacher::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Student::class, 'receiver_id');
    }
}
