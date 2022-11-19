<x-app-layout>
    <h1 class="text-2xl font-normal mb-10 text-center">Edit a Project</h1>

    <form method="POST" action="{{ $project->path() }}" class="mx-auto container md:max-w-4xl">
        @method('PATCH')
        @include('projects.form', [
            'buttonText' => 'Update Project'
        ])
    </form>
</x-app-layout>