<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        $tasksQuery = Task::query();

        $tasksQuery = $tasksQuery->when(
            $request->has('startFrom'),
            function ($query) use ($request) {
                try {
                    return $query->whereDate('created_at', ' >=', Carbon::parse($request->query('startFrom'))->format('Y-m-d h:m:s'));
                } catch (\Exception $e) {
                    return $query;
                }
            });

        $tasksQuery = $tasksQuery->when($request->has('status'),
            function ($query) use ($request) {
                return $query->where('status', $request->query('status'));
            }
        );

        return $tasksQuery->get()->makeVisible(['exec_time', 'user'])->makeHidden(['user_id']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $task = Task::query()->create([
                'name' => $request->json('name'),
                'description' => $request->json('description'),
            ]);
            $task->status = $request->json('status');
            $task->save();
            return response($task);
        } catch (QueryException $exception) {
            return response('', status: 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \App\Models\Task
     */
    public function show(Task $task)
    {
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        try {
            $task->update([
                'name' => $request->json('name'),
                'description' => $request->json('description'),
            ]);

            $task->status = $request->json('status') ?? $task->status;
        } catch (QueryException $exception) {
            return response('', status: 500);
        }
        $task->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
    }
}
