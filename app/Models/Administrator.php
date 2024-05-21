<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrator extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'access_code', 'CIN'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateProfilePhoto($photo, $user_id)
    {
        // dd($user_id);
        $user = User::find($user_id);

        if ($user->profile_photo_path) {
            $this->deleteProfilePhoto($user);
        }
        $path = $photo->store('profile-photos', 'public');
        $user->update(['profile_photo_path' => $path]);
    }

    public function deleteProfilePhoto($user)
    {
        // dd($user);
        Storage::disk('public')->delete($user->profile_photo_path);
        $user->update([
            'profile_photo_path' => null,
        ]);
    }
}
