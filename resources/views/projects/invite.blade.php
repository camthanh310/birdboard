<div class="bg-card py-5">
    <div class="mb-4 border-l-4 border-l-teal-400">
        <h3 class="font-semibold text-lg text-gray-800 pl-3">
            Invite a User
        </h3>
    </div>
    <div class="px-5">
        <form action="{{ $project->path() . '/invitations' }}" method="POST">
            @csrf
            <input type="email" name="email" class="w-full border border-teal-300 outline-none focus:ring-teal-300 mb-3" placeholder="Email address" />
            <button type="submit" class="bg-button hover:bg-teal-300 text-white py-2 px-8 rounded font-bold text-sm">
                Invite
            </button>
        </form>

        @include('projects.errors', ['bag' => 'invitations'])
    </div>
</div>