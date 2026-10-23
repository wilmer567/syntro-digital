<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show profile edit view.
     */
    public function index(): View
    {
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    /**
     * Update account info (name, email).
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('admin.profile.index')
            ->with('status', 'Datos de cuenta actualizados exitosamente.');
    }

    /**
     * Update account password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => [
                'required',
                'confirmed',
                'different:current_password',
                Password::min(12)->max(128)->mixedCase()->numbers()->symbols(),
            ],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->input('password')),
        ]);
        Auth::logoutOtherDevices($request->input('password'));
        $request->session()->regenerate();

        return redirect()->route('admin.profile.index')
            ->with('status', 'Contraseña actualizada con éxito.');
    }
}
