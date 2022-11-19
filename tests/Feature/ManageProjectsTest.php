<?php

use App\Models\Project;
use Tests\Setup\ProjectFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\delete;
use function Pest\Laravel\followingRedirects;
use function Pest\Laravel\get;
use function Pest\Laravel\patch;
use function Pest\Laravel\post;

it('guests cannot manage projects', function () {
    $project = Project::factory()->create();

    post('/projects', $project->toArray())->assertRedirect('login');
    get($project->path())->assertRedirect('login');
    get('/projects/create')->assertRedirect('login');
    get('/projects/edit')->assertRedirect('login');
    get('/projects')->assertRedirect('login');
});

it('a user can create a project', function () {
    signIn();

    get('/projects/create')->assertOk();

    followingRedirects()
        ->post('/projects', $attributes = Project::factory()->raw())
        ->assertSee($attributes['title'])
        ->assertSee($attributes['description'])
        ->assertSee($attributes['notes']);
});

it('a user can see all projects they have been invited to on their dashboard', function () {
    $project = tap(app(ProjectFactory::class)->create())->invite(signIn());

    get('/projects')->assertSee($project->title);
});

it('unauthorized users cannot delete a projects', function () {
    $project = app(ProjectFactory::class)->create();

    delete($project->path())->assertRedirect('/login');

    $user = signIn();

    delete($project->path())->assertForbidden();

    $project->invite($user);

    actingAs($user)
        ->delete($project->path())
        ->assertForbidden();
});

it('a user can delete a project', function () {
    $project = app(ProjectFactory::class)->create();

    actingAs($project->owner)
        ->delete($project->path())
        ->assertRedirect('/projects');

    assertDatabaseMissing('projects', $project->only('id'));
});

it('a user can update a project', function () {
    $project = app(ProjectFactory::class)
        ->create();

    actingAs($project->owner)
        ->patch($project->path(), $attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
        ->assertRedirect($project->path());

    get($project->path() . '/edit')->assertOk();

    assertDatabaseHas('projects', $attributes);
});

it('a user can update a projects general notes', function () {
    $project = app(ProjectFactory::class)
        ->create();

    actingAs($project->owner)
        ->patch($project->path(), $attributes = ['notes' => 'Changed'])
        ->assertRedirect($project->path());

    assertDatabaseHas('projects', $attributes);
});

it('a user can view their project', function () {
   $project = app(ProjectFactory::class)
       ->create();

    actingAs($project->owner)
        ->get($project->path())
        ->assertSee($project->title)
        ->assertSee($project->description);
});

it('an authenticated user cannot view the projects of others', function () {
    signIn();

    $project = Project::factory()->create();

    get($project->path())->assertForbidden();
});

it('an authenticated user cannot update the projects of others', function () {
    signIn();

    $project = Project::factory()->create();

    patch($project->path())->assertForbidden();
});

it('a project requires a title', function () {
    signIn();

    $attributes = Project::factory()->raw(['title' => '']);

    post('/projects', $attributes)->assertSessionHasErrors('title');
});

it('a project requires a description', function () {
    signIn();

    $attributes = Project::factory()->raw(['description' => '']);

    post('/projects', $attributes)->assertSessionHasErrors('description');
});






