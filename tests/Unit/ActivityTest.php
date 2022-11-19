<?php

use Tests\Setup\ProjectFactory;

test('has a user', function () {
    $user = signIn();

    $project = app(ProjectFactory::class)->ownedBy($user)->create();

    expect($user->id)
        ->toBe($project->activity->first()->user->id);
});
