<?php

use App\Models\Task;
use Tests\Setup\ProjectFactory;

use function Pest\Laravel\actingAs;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;

it('creating a project', function () {
    $project = app(ProjectFactory::class)
        ->create();

    assertCount(1, $project->activity);

    tap(
        $project->activity->first(),
        function ($activity) {
            assertEquals('created_project', $activity->description);

            assertNull($activity->changes);
        }
    );
});

it('updating a project', function () {
    $project = app(ProjectFactory::class)->create();
    $orginalTitle = $project->title;

    $project->update(['title' => 'changed']);

    assertCount(2, $project->activity);

    tap(
        $project->activity->last(),
        function ($activity) use ($orginalTitle) {
            assertEquals('updated_project', $activity->description);

            $expected = [
                'before' => ['title' => $orginalTitle],
                'after' => ['title' => 'changed'],
            ];

            assertEquals($expected, $activity->changes);
        }
    );
});

it('creating a new task', function () {
    $project = app(ProjectFactory::class)
        ->create();

    $project->addTask('some task');

    assertCount(2, $project->activity);
    tap(
        $project->activity->last(),
        function ($activity) {
            assertEquals('created_task', $activity->description);
            assertInstanceOf(Task::class, $activity->subject);
            assertEquals('some task', $activity->subject->body);
        }
    );
});

it('completing a new task', function () {
    $project = app(ProjectFactory::class)
        ->withTasks(1)
        ->create();

    actingAs($project->owner)
        ->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => true,
        ]);


    assertCount(3, $project->activity);

    tap(
        $project->activity->last(),
        function ($activity) {
            assertEquals('completed_task', $activity->description);
            assertInstanceOf(Task::class, $activity->subject);
            assertEquals('foobar', $activity->subject->body);
        }
    );
});

it('incompleting a new task', function () {
    $project = app(ProjectFactory::class)
        ->withTasks(1)
        ->create();

    actingAs($project->owner)
        ->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => true,
        ]);
    assertCount(3, $project->activity);

    actingAs($project->owner)
        ->patch($project->tasks->first()->path(), [
            'body' => 'foobar',
            'completed' => false,
        ]);

    $project->refresh();

    assertCount(4, $project->activity);
    assertEquals('incompleted_task', $project->activity->last()->description);
});

it('deleting a task', function () {
    $project = app(ProjectFactory::class)
        ->withTasks(1)
        ->create();

    $project->tasks->first()->delete();

    assertCount(3, $project->activity);
    assertEquals('deleted_task', $project->activity->last()->description);
});

