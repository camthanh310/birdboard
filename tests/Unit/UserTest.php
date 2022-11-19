<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\Setup\ProjectFactory;

use function PHPUnit\Framework\assertCount;

test('a user has projects', function () {
    $user = User::factory()->create();

    expect($user->projects)
        ->toBeInstanceOf(Collection::class);
});

test('a user has accessible projects', function () {
    $john = signIn();

    app(ProjectFactory::class)->ownedBy($john)->create();

    assertCount(1, $john->accessibleProjects());

    $sally = User::factory()->create();
    $nick = User::factory()->create();

    $project = tap(app(ProjectFactory::class)->ownedBy($sally)->create())->invite($nick);

    assertCount(1, $john->accessibleProjects());

    $project->invite($john);
    assertCount(2, $john->accessibleProjects());
});
