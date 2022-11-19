<?php

use App\Models\Project;
use App\Models\Task;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

it('guests cannot add tasks to projects', function () {
    $project = Project::factory()->create();

    post($project->path() . '/tasks')->assertRedirect('login');
});

it('only the owner of a project may add tasks', function () {
    SignIn();

    $project = Project::factory()->create();

    post($project->path() . '/tasks', ['body' => 'Test task'])
        ->assertForbidden();

    assertDatabaseMissing('tasks', ['body' => 'Test task']);
});

it('only the owner of a project may update a task', function () {
    SignIn();

    $project = app(\Tests\Setup\ProjectFactory::class)
        ->withTasks(1)
        ->create();

    patch($project->tasks->first()->path(), [
        'body' => 'Changed',
        'completed' => true,
    ])
     ->assertForbidden();

    assertDatabaseMissing('tasks', [
        'body' => 'Changed',
        'completed' => true,
    ]);
});

it('a project can have tasks', function () {
    $project = app(\Tests\Setup\ProjectFactory::class)
        ->create();

    actingAs($project->owner)
        ->post($project->path() . '/tasks', ['body' => 'Test task']);

    get($project->path())
        ->assertSee('Test task');
});

it('a task can be updated', function () {
    $project = app(\Tests\Setup\ProjectFactory::class)
        ->withTasks(1)
        ->create();

    actingAs($project->owner)
        ->patch($project->tasks->first()->path(), [
            'body' => 'Changed',
        ]);

    assertDatabaseHas('tasks', [
        'body' => 'Changed',
    ]);
});

it('a task can be completed', function () {
    $project = app(\Tests\Setup\ProjectFactory::class)
        ->withTasks(1)
        ->create();

    actingAs($project->owner)
        ->patch($project->tasks->first()->path(), [
            'body' => 'Changed',
            'completed' => true,
        ]);

    assertDatabaseHas('tasks', [
        'body' => 'Changed',
        'completed' => true,
    ]);
});

it('a task can be marked as incomplete', function () {
    $project = app(\Tests\Setup\ProjectFactory::class)
        ->withTasks(1)
        ->create();

    actingAs($project->owner)
        ->patch($project->tasks->first()->path(), [
            'body' => 'Changed',
            'completed' => true,
        ]);

    assertDatabaseHas('tasks', [
        'body' => 'Changed',
        'completed' => true,
    ]);

    actingAs($project->owner)
        ->patch($project->tasks->first()->path(), [
            'body' => 'Changed',
            'completed' => false,
        ]);

    assertDatabaseHas('tasks', [
        'body' => 'Changed',
        'completed' => false,
    ]);
});

it('a task required a body', function () {
    $project = app(\Tests\Setup\ProjectFactory::class)
        ->create();

    $attributes = Task::factory()->raw(['body' => '']);

    actingAs($project->owner)
        ->post($project->path() . '/tasks', $attributes)
        ->assertSessionHasErrors('body');
});

