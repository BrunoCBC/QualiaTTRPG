<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function show(Request $request, string $username = null): View
    {
        if ($username) {
            $user = User::where('username', $username)->first();

            if (!$user) {
                abort(404, 'Usuário não encontrado');
            }
        } else {
            $user = $request->user();
        }

        return view('profile.show', [
            'user' => $user,
            'isOwnProfile' => !$username || $username == $request->user()->username,
        ]);
    }

    public function edit(Request $request, string $username): View
    {
        $user = User::where('username', $username)->first();
    
        if (!$user) {
            abort(404, 'Usuário não encontrado');
        }
    
        return view('profile.edit', [
            'user' => $user,
        ]);
    }    

    public function update(ProfileUpdateRequest $request, string $username): RedirectResponse
    {
        $user = User::where('username', $username)->firstOrFail(); // Buscar o usuário pelo username
    
        $user->fill($request->validated());
    
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
    
        return Redirect::route('profile.edit', ['username' => $user->username])
            ->with('status', 'profile-updated');
    }    

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
}
