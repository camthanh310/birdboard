<?php

use App\Models\Project;
use App\Models\Task;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

test('it belongs to a project', function () {
    $task = Task::factory()->create();

    assertInstanceOf(Project::class, $task->project);
});

test('it has a path', function () {
    $task = Task::factory()->create();

    assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
});

test('it can be completed', function () {
    $task = Task::factory()->create();

    assertFalse($task->completed);

    $task->complete();

    assertTrue($task->fresh()->completed);
});

test('it can be marked as incomplete', function () {
    $task = Task::factory()->create(['completed' => true]);

    assertTrue($task->completed);

    $task->incomplete();

    assertFalse($task->fresh()->completed);
});
