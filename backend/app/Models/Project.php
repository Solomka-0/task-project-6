<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Ramsey\Collection\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property mixed $analytics
 *
 * @property Collection $tasks
 * @property Collection $users
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
    ];

    protected $appends = [
        'tasks',
        'users',
        'analytics',
    ];

    protected $hidden = [
        'tasks',
        'users',
        'analytics'
    ];

    protected $user = null;

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getUsersAttribute()
    {
        return $this->users()->get();
    }

    public function getTasksAttribute()
    {
        return $this->tasks()->get()->sortByDesc('priority')->values();
    }

    public function getAnalyticsAttribute()
    {
        $lastMonthTasks = $this->tasks()->where('end_at', '>=', Carbon::now()->subMonth());
        $lastDayTasks = $this->tasks()->where('end_at', '>=', Carbon::now()->subDay());
        $lastWeekTasks = $this->tasks()->where('end_at', '>=', Carbon::now()->subWeek());

        if (!empty($this->user)) {
            $lastMonthTasks = $lastMonthTasks->where('user_id', '=', $this->user->id);
            $lastDayTasks = $lastDayTasks->where('user_id', '=', $this->user->id);
            $lastWeekTasks = $lastWeekTasks->where('user_id', '=', $this->user->id);
        }

        $lastMonthTasks = $lastMonthTasks->get();
        $lastDayTasks = $lastDayTasks->get();
        $lastWeekTasks = $lastWeekTasks->get();

        function getTime($tasks)
        {
            return array_sum($tasks->map(function ($task) {
                /** @var Task $task */
                return $task->exec_time;
            })->toArray());
        }

        // Расчет времени затраченного на все задачи
        $analytics = [];
        $analytics['time'] = [];
        $analytics['time']['full'] = getTime($this->tasks);
        $analytics['time']['last_month'] = getTime($lastMonthTasks);
        $analytics['time']['last_day'] = getTime($lastDayTasks);
        $analytics['time']['last_week'] = getTime($lastWeekTasks);
        $analytics['time'] = (object)$analytics['time'];

        return (object)$analytics;
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
