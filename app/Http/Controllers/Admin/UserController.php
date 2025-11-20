<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::withCount('orders')
            ->whereHas('orders')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        abort_if(! $user->orders()->exists(), 404);

        $user->load(['orders' => fn ($query) => $query->with('items.product')->latest()]);

        return view('admin.users.show', compact('user'));
    }
}

