<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $userQuery = User::query();
        if ($request->query('like')) {
            $userQuery
                ->where('name', 'like', '%' . $request->query('like') . '%')
                ->orWhere('email', 'like', '%' . $request->query('like') . '%');

        }
        return $userQuery->get();
    }

    public function show(User $user)
    {
        return $user->makeVisible('projects');
    }

    public function store()
    {
        dd('store');
    }
}
