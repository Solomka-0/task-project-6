<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Ramsey\Collection\Collection;

/**
 * @property Collection $tasks
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
    ];

    protected $hidden = [
        'tasks',
        'users',
    ];

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

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }
}
