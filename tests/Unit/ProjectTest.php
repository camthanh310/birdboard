<?php

use App\Models\Project;
use App\Models\User;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertTrue;

test('it has a path', function () {
    $project = Project::factory()->create();

    expect('/projects/' . $project->id)->toEqual($project->path());
});

test('it belongs to an owner', function () {
    $project = Project::factory()->create();

    expect($project->owner)->toBeInstanceOf(User::class);
});

test('it can add a test', function () {
    $project = Project::factory()->create();

    $task = $project->addTask('Test task');

    assertCount(1, $project->tasks);

    assertTrue($project->tasks->contains($task));
});

test('it can invite a user', function () {
    $project = Project::factory()->create();

    $project->invite($user = User::factory()->create());

    assertTrue($project->members->contains($user));
});


