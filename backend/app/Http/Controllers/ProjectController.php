<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ProjectController extends Controller
{
    public function index()
    {
        return Project::all()->makeVisible(['tasks', 'users']);
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show(Project $project, Request $request)
    {
        $access = array_intersect([Role::ADMIN->value, Role::MANAGER->value], Auth::user()->rules);
        if (empty($access) && !empty($request->query('analytics'))) {
            throw new AccessDeniedHttpException();
        }


        if (!empty($request->query('analytics'))) {
            return $project->makeVisible(['tasks', 'users', 'analytics']);
        }
        return $project->makeVisible(['tasks', 'users']);
    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
