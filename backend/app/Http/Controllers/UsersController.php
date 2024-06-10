<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

    public function show(Request $request, User $user)
    {
//        $access = array_intersect([Role::ADMIN->value, Role::MANAGER->value], Auth::user()->rules);
//        if (empty($access) && !empty($request->query('analytics')) && !array_search(Auth::user()->id, $user->projects->users->pluck('id')->toArray())) {
//            throw new AccessDeniedHttpException();
//        }

        if (!empty($request->query('analytics'))) {
            return $user->makeVisible(['analytics', 'projects', 'tasks']);
        }

        return $user->makeVisible(['projects', 'tasks']);
    }

    public function store()
    {
        dd('store');
    }
}
