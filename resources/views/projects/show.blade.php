<x-app-layout>
    <x-slot name="header">
        <div class="flex items-end justify-between">
            <div class="flex items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    <a href="{{ route('projects.index') }}">My Project</a> / {{ $project->title }}
                </h2>
            </div>
            <div class="flex items-center">
                @foreach ($project->members as $member)
                    <img
                        src="{{ gravatar_url($member->email) }}"
                        alt="{{ $member->name }}'s avatar"
                        class="rounded-full w-8 mr-2"
                    >
                @endforeach

                <img
                    src="{{ gravatar_url($project->owner->email) }}"
                    alt="{{ $project->owner->name }}'s avatar"
                    class="rounded-full w-8 mr-2"
                >

                <a
                    class="ml-3 bg-button hover:bg-teal-300 text-white py-2 px-8 rounded font-bold text-sm"
                    href="{{ route('projects.edit', ['project' => $project])  }}"
                >
                    Edit Project
                </a>
            </div>
        </div>
    </x-slot>

    <div>
        <h3 class="text-lg text-gray-500 mb-4">Tasks</h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="col-span-1 mb-4 md:mb-0 md:col-span-2">
                <div class="mb-6">
                    <div class="space-y-3">
                        @foreach ($project->tasks as $task)
                            <div class="bg-white py-3 px-6">
                                <form action="{{ $task->path() }}" method="POST">
                                    @method('PATCH')
                                    @csrf
                                    <div class="flex items-center">
                                        <input
                                            name="body"
                                            value="{{ $task->body }}"
                                            class="w-full border-none outline-none focus:ring-teal-300 {{ $task->completed ? 'text-gray-400' : '' }}"
                                        />
                                        <input
                                            name="completed"
                                            type="checkbox"
                                            onChange="this.form.submit()"
                                            {{ $task->completed ? 'checked' : '' }}
                                        />
                                    </div>
                                </form>
                            </div>
                        @endforeach

                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input
                                type="text"
                                placeholder="Add a new tasks..."
                                class="w-full border-none outline-none focus:ring-teal-300 px-6 py-3"
                                name="body"
                            />
                        </form>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg text-gray-500 mb-4">General Notes</h3>
                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <textarea
                            name="notes"
                            class="w-full min-h-[12.5rem] border-none outline-none focus:ring-teal-300 mb-4"
                            placeholder="Anything special that you want to make a note of?"
                        >{{ $project->notes }}</textarea>
                        <button type="submit" class="bg-button hover:bg-teal-300 text-white py-2 px-8 rounded font-bold text-sm">Save</button>
                    </form>

                    @include('projects.errors')
                </div>
            </div>
            <div class="col-span-1 space-y-3">
                <x-card :project="$project">
                    <a href="/projects">Go back</a>
                </x-card>

                @include('projects.activity.card')

                @can('manage', $project)
                    @include('projects.invite')
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>