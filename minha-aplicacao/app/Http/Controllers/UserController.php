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

    public function syncProfiles(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'profiles' => ['array'],
            'profiles.*' => ['integer', 'exists:profiles,id'],
        ]);

        $user->profiles()->sync($validated['profiles'] ?? []);

        return back()->with('success', 'Perfis atualizados com sucesso.');
    }

    public function index(): Response
    {
        return Inertia::render('Users/Index', [
            'users' => User::select('id', 'name', 'email')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Users/Create', [
            'profiles' => Profile::select('id', 'profile')->get(),
        ]);
    }

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

    public function edit(User $user): Response
    {
        return Inertia::render('Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso.');
    }

    public function show(User $user): Response
    {
        return Inertia::render('Users/Show', [
            'user' => $user,
            'profiles' => Profile::select('id', 'profile')->get(),
            'attachedProfileIds' => $user->profiles()->pluck('id')->toArray(),
        ]);
    }
}

