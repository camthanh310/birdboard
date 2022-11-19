<?php

namespace Tests\Setup;

use App\Models\User;

class ProjectFactory
{
    protected int $tasksCount = 0;

    protected ?User $user = null;

    public function withTasks($count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy(User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function create()
    {
        $project = \App\Models\Project::factory()->create(
            ['owner_id' => $this->user ?? User::factory()]
        );

        \App\Models\Task::factory()->count($this->tasksCount)->create([
            'project_id' => $project->id,
        ]);

        return $project;
    }
}
