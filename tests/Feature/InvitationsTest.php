<?php

use App\Http\Controllers\ProjectTasksController;
use App\Models\User;
use Tests\Setup\ProjectFactory;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;
use function PHPUnit\Framework\assertTrue;

it('non owners may not invite users', function () {
    $project = app(ProjectFactory::class)->create();

    $user = User::factory()->create();

    $assertInvitationForbidden = function () use ($user, $project) {
        actingAs($user)
            ->post($project->path() . '/invitations')
            ->assertStatus(403);
    };

    $assertInvitationForbidden();

    $project->invite($user);

    $assertInvitationForbidden();
});

it('a project can invite a user', function () {
    $project = app(ProjectFactory::class)
        ->create();

    $userToInvite = User::factory()->create();

    actingAs($project->owner)
        ->post($project->path() . '/invitations', [
        'email' => $userToInvite->email,
    ])
    ->assertRedirect($project->path());

    assertTrue($project->members->contains($userToInvite));
});

it('the invited email address must be associated a valid birdboard account', function () {
    $project = app(ProjectFactory::class)
        ->create();

    actingAs($project->owner)
        ->post($project->path() . '/invitations', [
        'email' => 'naruto@example.com'
    ])
    ->assertSessionHasErrors([
        'email' => 'The user you are inviting must have a Birdboard account.',
    ], errorBag: 'invitations');
});

it('invited users may update project details', function () {
    $project = app(ProjectFactory::class)->create();

    $project->invite($newUser = User::factory()->create());

    signIn($newUser);
    post(
        action([ProjectTasksController::class, 'store'], $project),
        $task = ['body' => 'Foo task']
    );

    assertDatabaseHas('tasks', $task);
});
