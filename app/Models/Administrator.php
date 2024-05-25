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
        $user = User::find($user_id);

        if ($user->profile_photo_path) {
            $this->deleteProfilePhoto($user);
        }
        // $path = $photo->store('profile-photos', 'public');
        $path = $photo->storePublicly(
            'profile-photos',
            ['disk' => 'public']
        );
        // dd($path);
        $user->update(['profile_photo_path' => $path]);
    }

    public function deleteProfilePhoto($user)
    {

        if ($user->profile_photo_path) {
            // Check if the file exists in the storage
            if (Storage::disk('public')->exists($user->profile_photo_path)) {
                // Delete the file from the storage
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            // Update the user's profile_photo_path to null
            $user->update([
                'profile_photo_path' => null,
            ]);
        }
        // dd($user);
        // Storage::disk('public')->delete($user->profile_photo_path);
        // $user->update([
        //     'profile_photo_path' => null,
        // ]);
    }
}
