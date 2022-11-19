@props(['project'])

<div class="bg-card py-5">
    <div class="mb-4 border-l-4 border-l-teal-400">
        <h3 class="font-semibold text-lg text-gray-800 pl-3">
            <a href="{{ $project->path() }}">{{ $project->title }}</a>
        </h3>
    </div>
    <div class="px-5">
        <p class="text-medium text-gray-500">
            {{ Str::limit($project->description, 100) }}
        </p>
        <div>
            {{ $slot }}
        </div>

        @can('manage', $project)
        <form action="{{ $project->path() }}" method="POST" class="text-right mt-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs">
                Delete
            </button>
        </form>
        @endcan
    </div>
</div>