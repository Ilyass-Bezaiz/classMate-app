<?php

namespace App\Actions\Fortify;

use App\Enums\Role;
use App\Models\Administrator;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        $admin = null;
        $teacher = null;
        $student = null;
        // ? check the logged user
        if ($user->role == Role::ADMIN) {
            $admin = Administrator::where("user_id", $user->id)->first();
        } elseif ($user->role == Role::TEACHER) {
            $teacher = Teacher::where("user_id", $user->id)->first();
        } else {
            $student = Student::where("user_id", $user->id)->first();
        }

        //? Make the rules of verification
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ];
        //     'name' => ['required', 'string', 'max:255'],
        // Validator::make($input, [
        //     'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        //     'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        // ])->validateWithBag('updateProfileInformation');

        //! check the role to add correct field
        if ($admin || $teacher) {
            $rules['CIN'] = ['string', 'required', 'max:10'];
        } else {
            $rules['CNE'] = ['string', 'required', 'max:22'];
        }

        // ? Validate the rules
        Validator::make($input, $rules)->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }

        if ($admin) {
            $admin->update(['CIN' => $input['CIN']]);
        } elseif ($teacher) {
            $teacher->update(['CIN' => $input['CIN']]);
        } elseif ($student) {
            $student->update(['CNE' => $input['CNE']]);
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
