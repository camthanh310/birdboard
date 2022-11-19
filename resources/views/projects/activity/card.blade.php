<div class="bg-card py-5">
    <ul class="px-5 space-y-3">
        @foreach ($project->activity as $activity)
            <li class="text-sm text-gray-500">
                @include("projects.activity.{$activity->description}")
                <span class="text-gray-400">{{ $activity->created_at->diffForHumans(null, true) }}</span>
            </li>
        @endforeach
    </ul>
</div>