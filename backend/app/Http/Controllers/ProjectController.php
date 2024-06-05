<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

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

    public function show(Project $project)
    {
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
