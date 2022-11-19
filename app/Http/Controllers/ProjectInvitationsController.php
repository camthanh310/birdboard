<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitaionRequest;
use App\Models\Project;
use App\Models\User;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project, ProjectInvitaionRequest $request)
    {
        $user = User::query()->whereEmail($request->validated())->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
