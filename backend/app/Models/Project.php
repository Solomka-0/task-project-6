<?php

namespace App\Models;

use App\Enums\Chart;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
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

    protected function getTime($tasks, CarbonPeriod $period = null)
    {
        return array_sum($tasks->map(function ($task) use ($period) {
            if (!empty($period)) {
                if (!empty($task->start_at) && $period->startsBefore($task->start_at)) {
                    $period->setStartDate($task->start_at);
                }
                if (!empty($task->end_at) && $period->endsAfter($task->end_at)) {
                    $period->setEndDate($task->end_at);
                }
                return $period->getEndDate()->toDateTime()->diff($period->getStartDate()->toDateTime())->h;
            }
            /** @var Task $task */
            return $task->exec_time;
        })->toArray());
    }

    public function chart(Chart $chart = Chart::MONTH)
    {
        $result = [];

        switch ($chart) {
            case Chart::MONTH:
                $period = CarbonPeriod::create(Carbon::now()->subMonths(12), Carbon::now());
                $period = $period->ceilMonth(1);
                foreach ($period as $date) {
                    $query = $this->tasks()
                        ->whereBetween('start_at', [$date->startOfMonth()->toDate(), $date->endOfMonth()->toDate()])
                        ->orWhere('end_at', [$date->startOfMonth()->toDate(), $date->endOfMonth()->toDate()])
                    ;

                    $data = $query->get();
                    $date->locale('ru');
                    $result[$date->getTranslatedMonthName()] = $this->getTime($data);
                }
                break;
            case Chart::WEEK:
                $period = CarbonPeriod::create(Carbon::now()->subMonth(3), Carbon::now());
                $period = $period->ceilWeek(1);
                foreach ($period as $date) {
                    $query = $this->tasks()
                        ->whereBetween('start_at', [$date->startOfWeek()->toDate(), $date->endOfWeek()->toDate()])
                        ->orWhere('end_at', [$date->startOfWeek()->toDate(), $date->endOfWeek()->toDate()])
                    ;

                    $data = $query->get();
                    $date->locale('ru');
                    $result[$date->format('m.d')] = $this->getTime($data, CarbonPeriod::create($date->startOfWeek()->toDate(), $date->endOfWeek()->toDate()));
                }
                break;
            case Chart::DAY:
                $period = CarbonPeriod::create(Carbon::now()->subMonth(), Carbon::now());
                $period = $period->ceilDay(1);
                foreach ($period as $date) {
                    $query = $this->tasks()
                        ->whereBetween('start_at', [$date->startOfDay()->toDate(), $date->endOfDay()->toDate()])
                        ->orWhere('end_at', [$date->startOfDay()->toDate(), $date->endOfDay()->toDate()])
                    ;

                    $data = $query->get();
                    $result[$date->day] = $this->getTime($data, CarbonPeriod::create($date->startOfDay()->toDate(), $date->endOfDay()->toDate()));
                }
                break;
        }

        return (object)$result;
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

        // Расчет времени затраченного на все задачи
        $analytics = [];
        $analytics['time'] = [];
        $analytics['time']['full'] = $this->getTime($this->tasks);
        $analytics['time']['last_month'] = $this->getTime($lastMonthTasks);
        $analytics['time']['last_day'] = $this->getTime($lastDayTasks);
        $analytics['time']['last_week'] = $this->getTime($lastWeekTasks);
        $analytics['time'] = (object)$analytics['time'];

        $analytics['chart'] = [];
        $analytics['chart']['month'] = $this->chart();
        $analytics['chart']['week'] = $this->chart(Chart::WEEK);
        $analytics['chart']['day'] = $this->chart(Chart::DAY);
        $analytics['chart'] = (object)$analytics['chart'];

        return (object)$analytics;
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
