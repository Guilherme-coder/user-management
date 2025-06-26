<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{

    /**
     * Sync profiles in user.
     */
    public function syncProfiles(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'profiles' => ['array'],
            'profiles.*' => ['integer', 'exists:profiles,id'],
        ]);

        $user->profiles()->sync($validated['profiles'] ?? []);

        return back()->with('success', 'Perfis atualizados com sucesso.');
    }

    /**
     * List all users.
     */
    public function index(): Response
    {
        return Inertia::render('Users/Index', [
            'users' => User::select('id', 'name', 'email')->paginate(10),
        ]);
    }

    /**
     * Show user details.
     */
    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => $user,
            'profiles' => Profile::select('id', 'profile')->get(),
            'attachedProfileIds' => $user->profiles()->pluck('id')->toArray(),
        ]);
    }

    /**
     * Display the user create form.
     */
    public function create(): Response
    {
        return Inertia::render('Users/Create', [
            'profiles' => Profile::select('id', 'profile')->get(),
        ]);
    }

    /**
     * Store a user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'profiles' => ['array'],
            'profiles.*' => ['integer', 'exists:profiles,id'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        $user->profiles()->sync($validated['profiles'] ?? []);

        return redirect()->route('users.index')->with('success', 'Usuário criado com sucesso.');
    }

    /**
     * Display the user edit form.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update a user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return redirect()
                ->route('users.index')
                ->with('error', 'Não é permitido excluir um usuário com perfil Administrador.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario deletado com sucesso.');
    }
}

