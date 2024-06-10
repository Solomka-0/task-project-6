<?php

namespace App\Models;

use App\Enums\Chart;
use App\Enums\TaskStatus;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Collection\Collection;

/**
 * @property int $id
 * @property string $name
 * @property array<string> $rules
 * @property string $password
 * @property ?DateTime $created_at
 * @property ?DateTime $updated_at
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $appends = [
        'analytics',
        'projects',
        'tasks',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'analytics',
        'projects',
        'tasks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'rules' => 'array'
    ];

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

    public function chart(Chart $chart = Chart::MONTH, $projectId = null)
    {
        $result = [];

        switch ($chart) {
            case Chart::MONTH:
                $period = CarbonPeriod::create(Carbon::now()->subMonths(12), Carbon::now());
                $period = $period->ceilMonth(1);
                foreach ($period as $date) {
                    $query = $this->projects()->find($projectId)->tasks()->getQuery()->where('user_id', $this->id)
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
                    $query = $this->projects()->find($projectId)->tasks()->getQuery()->where('user_id', $this->id)
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
                    $query = $this->projects()->find($projectId)->tasks()->getQuery()->where('user_id', $this->id)
                        ->whereBetween('start_at', [$date->startOfDay()->toDate(), $date->endOfDay()->toDate()])
                        ->orWhere('end_at', [$date->startOfDay()->toDate(), $date->endOfDay()->toDate()])
                    ;

                    $data = $query->get();
                    $result[$date->format('m.d')] = $this->getTime($data, CarbonPeriod::create($date->startOfDay()->toDate(), $date->endOfDay()->toDate()));
                }
                break;
        }

        return (object)$result;
    }

    public function getAnalyticsAttribute()
    {
        $analytics = [];
        $analytics['projects']['count'] = $this->projects()->count();
        $analytics['tasks']['count'] = Task::query()->where('user_id', $this->id)->whereIn('status', [TaskStatus::IN_PROCESS->value, TaskStatus::NOT_STARTED->value])->count();
        $analytics['projects']['items'] = [];
        $analytics['projects']['full'] = 0;
        $analytics['full'] = [];

        $analytics['full']['chart'] = [];
        $analytics['full']['chart']['month'] = [];
        $analytics['full']['chart']['week'] = [];
        $analytics['full']['chart']['day'] = [];
        foreach ($this->projects as $project) {
            $analytics['projects']['items'][$project->id] = [];

            $analytics['projects']['items'][$project->id]['chart']['month'] = $this->chart(projectId: $project->id);
            foreach ($analytics['projects']['items'][$project->id]['chart']['month'] as $key => $data) {
                try {
                    $analytics['full']['chart']['month'][$key] += $data;
                } catch (\Exception $e) {
                    $analytics['full']['chart']['month'][$key] = $data;
                }
            }


            $analytics['projects']['items'][$project->id]['chart']['week'] = $this->chart(Chart::WEEK, projectId: $project->id);
            foreach ($analytics['projects']['items'][$project->id]['chart']['week'] as $key => $data) {
                try {
                    $analytics['full']['chart']['week'][$key] += $data;
                } catch (\Exception $e) {
                    $analytics['full']['chart']['week'][$key] = $data;
                }
            }
            $analytics['projects']['items'][$project->id]['chart']['day'] = $this->chart(Chart::DAY, projectId: $project->id);
            foreach ($analytics['projects']['items'][$project->id]['chart']['day'] as $key => $data) {
                try {
                    $analytics['full']['chart']['day'][$key] += $data;
                } catch (\Exception $e) {
                    $analytics['full']['chart']['day'][$key] = $data;
                }
            }
            $analytics['projects']['full'] += array_sum(get_object_vars($this->chart(Chart::DAY, projectId: $project->id)));
            $analytics['projects']['items'][$project->id]['chart'] = (object)$analytics['projects']['items'][$project->id]['chart'];
            $analytics['projects']['items'][$project->id] = (object)$analytics['projects']['items'][$project->id];

        }

        $analytics['full']['time'] = [];
        $analytics['full']['time']['full'] = array_sum($analytics['full']['chart']['month']);
        $analytics['full']['time']['last_month'] = end($analytics['full']['chart']['month']);
        $analytics['full']['time']['last_day'] = end($analytics['full']['chart']['day']);
        $analytics['full']['time']['last_week'] = end($analytics['full']['chart']['week']);
        $analytics['full']['time'] = (object)$analytics['full']['time'];

        $analytics['full']['chart'] = (object)$analytics['full']['chart'];
        $analytics['full'] = (object)$analytics['full'];


        $analytics['projects'] = (object)$analytics['projects'];

        return (object)$analytics;
    }

    public function getProjectsAttribute()
    {
        return $this->projects()->get()->makeVisible(['users', 'tasks']);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function getTasksAttribute()
    {
        return $this->tasks()
            ->orderBy('created_at', 'desc')
            ->get()->makeVisible(['user']);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
