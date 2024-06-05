<?php

namespace App\Models;

use App\Enums\TaskStatus;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Ramsey\Collection\Collection;

/**
 * @property string $name
 * @property string $description
 * @property TaskStatus $status
 * @property string $user_id
 * @property ?DateTime $created_at
 * @property ?DateTime $updated_at
 * @property ?DateTime $start_at
 * @property ?DateTime $end_at
 * @property ?int $exec_time
 *
 * @property Collection $projects
 * @property DateTime minCreatedTime
 */
class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
        'created_at',
        'updated_at',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = [
        'exec_time',
        'user',
        'project'
    ];

    protected $hidden = [
        'start_at',
        'end_at',
        'exec_time',
        'user',
        'project'
    ];

    public function getExecTimeAttribute()
    {
        return !empty($this->start_at)
            ? (!empty($this->end_at)
                ? (new DateTime($this->end_at))->diff(new DateTime($this->start_at))->h
                : (new DateTime($this->end_at))->diff(now())->h)
            : null;
    }

    public function getUserAttribute()
    {
        return $this->user()->get();
    }

    public function getProjectAttribute()
    {
        return $this->user()->get();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'project_task');
    }

    /**
     * @return Carbon
     */
    public function minCreatedTime()
    {
        return $this->projects->sort(function ($item): mixed {
            return $item->created_at->getTimestamp();
        })->first()->created_at;
    }
}
