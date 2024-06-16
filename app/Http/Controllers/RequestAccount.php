<?php

namespace App\Http\Controllers;

use App\Jobs\SendRequestAccountEmail;
use Illuminate\Http\Request;
use Masmerise\Toaster\Toaster;
use App\Mail\RequestAccountEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


class RequestAccount extends Controller
{
    public function store(Request $request)
    {
        // dd($request->role);
        $validator = Validator::make($request->all(), [
            'photo' => 'nullable|image|max:2048'
        ]);
        $details = [];
        if ($request->role == 'etudiant') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'CNE' => 'required|string|max:255',
                'classe' => 'required|string|max:255',
            ]);
            $details = [
                'name' => $request->name,
                'email' => $request->email,
                'CNE' => $request->CNE,
                'classe' => $request->classe,
                'role' => $request->role
            ];
        } else if ($request->role == 'professeur') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'CIN' => 'required|string|max:255',
                'diploma' => 'required|string|max:255',
            ]);
            $details = [
                'name' => $request->name,
                'email' => $request->email,
                'CIN' => $request->CIN,
                'diploma' => $request->diploma,
                'role' => $request->role
            ];
        }


        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }


        try {
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new RequestAccountEmail($details));
            // dd($details);
            // SendRequestAccountEmail::dispatch($details);
        } catch (\Exception $e) {
            dd($e);
        }
        // return redirect('/');
        // return redirect()->route('etudiant.accueil')->with('success', 'Compte créé avec succès!');
    }
}
