<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function index(): Response
    {
        $profiles = Profile::all();
        return Inertia::render('Profiles/Index', ['profiles' => $profiles]);
    }

    public function create(): Response
    {
        return Inertia::render('Profiles/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'profile' => ['required', 'string', 'max:255'],
        ]);

        Profile::create($validated);

        return redirect()->route('profiles.index')->with('success', 'Perfil criado com sucesso.');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, Profile $profile): RedirectResponse
    {
        $validated = $request->validate([
            'profile' => ['required', 'string', 'max:255'],
        ]);

        $profile->update($validated);

        return redirect()->route('profiles.index')->with('success', 'Perfil atualizado com sucesso.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Profile $profile): RedirectResponse
    {
        $profile->delete();
        return redirect()->route('profiles.index')->with('success', 'Perfil deletado com sucesso.');
    }
}
