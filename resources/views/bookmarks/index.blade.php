<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookmarks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($bookmarks->isEmpty())
                    <p>You have no bookmarks.</p>
                @else
                    <ul>
                        @foreach ($bookmarks as $bookmark)
                            <li class="mb-4">
                                <div class="flex items-center">
                                    <img src="{{ asset('storage/' . $bookmark->pastQuestion->image) }}" alt="Past Question Image" class="w-12 h-12 mr-4">
                                    <a href="{{ route('pastQuestions.view', $bookmark->pastQuestion->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        {{ $bookmark->pastQuestion->title ?? 'View Past Question' }}
                                    </a>
                                    <form method="POST" action="{{ route('bookmarks.destroy', $bookmark->pastQuestion->id) }}" class="ml-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Remove Bookmark</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
