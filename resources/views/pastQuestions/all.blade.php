<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Show PastQuestions') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                            <h2 class="text-2xl font-semibold leading-tight mb-6">Past Questions</h2>

                            @if ($pastQuestions->isEmpty())
                                <p>No past questions available.</p>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course Title</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($pastQuestions as $pastQuestion)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pastQuestion->course->name }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">{{ $pastQuestion->year }}</td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <a href="{{ route('pastQuestions.edit', $pastQuestion->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                                        <form action="{{ route('pastQuestions.destroy', $pastQuestion->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
