@csrf

<div class="mb-6">
    <x-input-label for="title" class="mb-3">Title</x-input-label>
    <x-text-input
        type="text"
        name="title"
        placeholder="My next awesome project"
        id="title"
        value="{{ $project->title }}"
        required
    />
</div>

<div class="mb-6">
    <x-input-label for="description" class="mb-3">Description</x-input-label>
    <textarea
        name="description"
        id="description"
        cols="30"
        rows="10"
        class="w-full min-h-[12.5rem] border-none outline-none focus:ring-teal-300 mb-4 py-3 px-6"
        required
    >{{ $project->description }}</textarea>
</div>

<div class="space-x-4">
    <button type="submit" class="bg-button hover:bg-teal-300 text-white py-2 px-8 rounded font-bold text-sm">
        {{ $buttonText }}
    </button>
    <a href="{{ $project->path() }}">Cancel</a>
</div>

@if ($errors->any())
<div class="mt-6">
    @foreach ($errors->all() as $error)
        <li class="text-sm text-red-500">{{ $error }}</li>
    @endforeach
</div>
@endif