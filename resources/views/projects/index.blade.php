<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-end">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Birdboard
            </h2>
            <a href="/projects/create" class="bg-button hover:bg-teal-300 text-white py-2 px-8 rounded font-bold text-sm">New Project</a>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 gap-y-2 md:grid-cols-3 md:gap-4">
        @forelse ($projects as $project)
            <div class="col-span-1 mb-4 md:mb-0">
                <x-card :project="$project" />
            </div>
        @empty
            <div class="font-bold text-xl text-gray-800">No projects yet.</div>
        @endforelse
    </div>
</x-app-layout>