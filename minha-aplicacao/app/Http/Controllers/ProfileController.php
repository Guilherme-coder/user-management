<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    public function syncUsers(Request $request, Profile $profile): RedirectResponse
    {
        $validated = $request->validate([
            'users' => ['array'],
            'users.*' => ['integer', 'exists:users,id'],
        ]);

        $profile->users()->sync($validated['users'] ?? []);

        return back()->with('success', 'Usuários atualizados com sucesso.');
    }

    public function index(): Response
    {
        $profiles = Profile::all();
        return Inertia::render('Profiles/Index', ['profiles' => $profiles]);
    }

    public function show(Profile $profile): Response
    {
        return Inertia::render('Profiles/Show', [
            'profile' => $profile,
            'usersWithProfile' => $profile->users()->select('id', 'name', 'email')->get(),
            'allUsers' => User::select('id', 'name', 'email')->get(),
            'attachedUserIds' => $profile->users()->pluck('id')->toArray(),
        ]);
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
    public function edit(Profile $profile): Response
    {
        $users = User::all();

        return Inertia::render('Profiles/Edit', [
            'profile' => $profile,
            'users' => $users,
            'attachedUserIds' => $profile->users()->pluck('id')->toArray(),
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
        if (in_array(strtolower($profile->profile), ['administrador', 'usuario'])) {
            return redirect()->route('profiles.index')->with('error', 'Este perfil não pode ser excluído.');
        }

        $profile->delete();
        return redirect()->route('profiles.index')->with('success', 'Perfil deletado com sucesso.');
    }
}
