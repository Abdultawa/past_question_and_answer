<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-center mb-6">
                    <img src="{{ asset('storage/' . $pastQuestion->image) }}" alt="Past Question Image" class="w-1/2 h-auto rounded-lg shadow-lg">
                </div>
                <div class="text-center mb-6">
                    <a href="{{ route('pastQuestions.download', $pastQuestion->id) }}" class="text-indigo-600 hover:text-indigo-900 underline">
                        Download PDF
                    </a>
                </div>
                <div class="text-center mb-6">
                    @if(auth()->user()->bookmarks()->where('past_question_id', $pastQuestion->id)->exists())
                        <form method="POST" action="{{ route('bookmarks.destroy', $pastQuestion->id) }}" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                Remove Bookmark
                            </button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('bookmarks.store', $pastQuestion->id) }}" class="inline-block">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                                Add to Bookmark
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <x-panel>
        <form method="POST" action="{{ route('comments.store', $pastQuestion->id) }}">
            @csrf

            <header class="flex items-center mb-4">
                <img src="https://i.pravatar.cc/60?u={{ auth()->id() }}" alt="" width="40" height="40" class="rounded-full mr-4">
                <h2 class="text-xl">Want to participate?</h2>
            </header>

            <div class="mb-6">
                <textarea
                    name="body"
                    class="w-full text-sm focus:outline-none focus:ring border border-gray-300 rounded p-2"
                    rows="5"
                    placeholder="Quick, think of something to say!"
                    required></textarea>

                @error('body')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <x-form.button>Submit</x-form.button>
            </div>
        </form>
    </x-panel>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @foreach ($pastQuestion->comments as $comment)
                <x-comment :comment="$comment"/>
            @endforeach
        </div>
    </div>
</x-app-layout>
