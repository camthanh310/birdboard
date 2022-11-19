<x-app-layout>
    <h1 class="text-2xl font-normal mb-10 text-center">
        Let's start something new
    </h1>
    <form method="POST" action="/projects" class="mx-auto container md:max-w-4xl">
        @include('projects.form', [
            'project' => new \App\Models\Project,
            'buttonText' => 'Create Project'
        ])
    </form>

</x-app-layout>