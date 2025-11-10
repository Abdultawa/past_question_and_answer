<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold leading-tight mb-6">{{ $course->name }}</h2>

        <div class="bg-gray-50 shadow overflow-hidden sm:rounded-lg p-4">
            <h3 class="text-lg font-semibold leading-tight mb-4">Past Questions</h3>
            @if($course->pastQuestions->isEmpty())
                <p class="text-gray-500">No past questions available for this course.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach ($course->pastQuestions as $pastQuestion)
                        <li class="px-4 py-4 sm:px-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-indigo-600">{{ $pastQuestion->year }}</p>
                                    <p class="text-sm text-gray-500">{{ $course->name }}</p>
                                </div>
                                <!-- <div>
                                    <a href="{{ route('pastQuestions.download', $pastQuestion->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Download PDF
                                    </a>
                                </div> -->
                                <div>
                                <a href="{{ route('pastQuestions.view', $pastQuestion->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                        View Question
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>


