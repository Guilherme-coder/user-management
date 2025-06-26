<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\StoreProfileRequest;
use App\Http\Requests\Profile\SyncProfileUsersRequest;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{

    /**
     * Sync users in profile.
     */
    public function syncUsers(SyncProfileUsersRequest $request, Profile $profile): RedirectResponse
    {
        $profile->users()->sync($request->validated('users') ?? []);

        return back()->with('success', 'Usuários atualizados com sucesso.');
    }

    /**
     * List all profiles.
     */
    public function index(): Response
    {
        $profiles = Profile::select('id', 'profile')->paginate(10);
        return Inertia::render('Profiles/Index', ['profiles' => $profiles]);
    }

    /**
     * Show profile details.
     */
    public function show(Profile $profile): Response
    {
        return Inertia::render('Profiles/Show', [
            'profile' => $profile,
            'usersWithProfile' => $profile->users()->select('id', 'name', 'email')->get(),
            'allUsers' => User::select('id', 'name', 'email')->get(),
            'attachedUserIds' => $profile->users()->pluck('id')->toArray(),
        ]);
    }

    /**
     * Display the profile create form.
     */
    public function create(): Response
    {
        return Inertia::render('Profiles/Create');
    }

    /**
     * Store a profile.
     */
    public function store(StoreProfileRequest $request): RedirectResponse
    {
        Profile::create($request->validated());

        return redirect()->route('profiles.index')->with('success', 'Perfil criado com sucesso.');
    }

    /**
     * Display the profile edit form.
     */
    public function edit(Profile $profile): Response
    {
        return Inertia::render('Profiles/Edit', [
            'profile' => $profile,
        ]);
    }

    /**
     * Update the profile information.
     */
    public function update(UpdateProfileRequest $request, Profile $profile): RedirectResponse
    {
        $profile->update($request->validated());

        return redirect()->route('profiles.index')->with('success', 'Perfil atualizado com sucesso.');
    }

    /**
     * Delete profile.
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
