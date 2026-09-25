<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\Core\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * List the users who can sign in to the admin panel.
     */
    public function index(): Response
    {
        $users = User::orderBy('name')
                    ->get();

        return Inertia::render('core/users/Index', compact('users'));
    }

    /**
     * Show the form to create a user.
     */
    public function create(): Response
    {
        return Inertia::render('core/users/Form', [
            'user' => null,
        ]);
    }

    /**
     * Store a new user; the model hashes the password on save.
     */
    public function store(UserRequest $request): RedirectResponse
    {
        $data = $request->validated();

        User::create($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('User created.'),
            ]
        );

        return to_route('core.users.index');
    }

    /**
     * Users are edited from the index; there is no detail page.
     */
    public function show(): never
    {
        abort(404);
    }

    /**
     * Show the form to edit a user.
     */
    public function edit(User $user): Response
    {
        return Inertia::render('core/users/Form', [
            'user' => $user,
        ]);
    }

    /**
     * Update a user, keeping the current password when none is provided.
     */
    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        $password = $data['password'] ?? null;

        if (blank($password)) {
            unset($data['password']);
        }

        $user->update($data);

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('User updated.'),
            ]
        );

        return to_route('core.users.index');
    }

    /**
     * Delete a user for good; users are not soft deleted.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        $current = $request->user();

        if ($current !== null && $current->is($user)) {
            Inertia::flash(
                'toast',
                [
                    'type' => 'error',
                    'message' => __('You cannot delete the account you are signed in with.'),
                ]
            );

            return to_route('core.users.index');
        }

        $user->delete();

        Inertia::flash(
            'toast',
            [
                'type' => 'success',
                'message' => __('User deleted.'),
            ]
        );

        return to_route('core.users.index');
    }
}
