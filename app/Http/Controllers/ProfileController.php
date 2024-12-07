<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        if ($request->hasFile('photo')) {
            $urlfile = $this->saveFile($request->file('photo'));
            $request->user()->fill([
                'photo' => $urlfile,
            ])->save();
        }
        $request->user()->fill([
               'name' => $request->name,
               'email' => $request->email,
               'firstname' => $request->firstname,
               'lastname' => $request->lastname,
               'phone' => $request->phone
        ]);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('success', 'Perfil actualizado con éxito.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function saveFile($archivo)
    {
        if ($archivo != null) {
            $uploadPath = public_path('/storage/profile/');
            $file = $archivo;
            $extension = $file->getClientOriginalExtension();
            $uuid = Str::uuid(4);
            $fileName = $uuid . '.' . $extension;
            $file->move($uploadPath, $fileName);
            $url = '/storage/profile/'.$fileName;
            $urlfile = $url;
        } else {
            $urlfile = null;
        }


        return $urlfile;
    }
}
