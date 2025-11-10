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
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-semibold leading-tight">Courses</h2>
                            <form method="GET" action="{{ route('courses.index') }}" class="flex space-x-2">
                                <input type="text" name="search" placeholder="Search courses..." value="{{ request('search') }}" class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Search
                                </button>
                            </form>
                        </div>
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6">
                            <h3 class="text-xl font-semibold leading-tight mb-4">ND Courses</h3>
                            @if($ndCourses->isEmpty())
                                <p class="text-gray-500">No ND courses available.</p>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                                    @foreach ($ndCourses as $course)
                                        <div class="bg-gray-100 shadow sm:rounded-lg p-4">
                                            <h4 class="text-lg font-semibold leading-tight mb-2">{{ $course->name }}</h4>
                                            <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                View Details
                                            </a>
                                            @admin
                                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline-block mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this course?');" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Delete
                                                </button>
                                            </form>
                                            @endadmin
                                        </div>
                                    @endforeach
                                </div>
                                {{ $ndCourses->appends(['search' => request('search')])->links() }}
                            @endif

                            <h3 class="text-xl font-semibold leading-tight mb-4">HND Courses</h3>
                            @if($hndCourses->isEmpty())
                                <p class="text-gray-500">No HND courses available.</p>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                                    @foreach ($hndCourses as $course)
                                        <div class="bg-gray-100 shadow sm:rounded-lg p-4">
                                            <h4 class="text-lg font-semibold leading-tight mb-2">{{ $course->name }}</h4>
                                            <a href="{{ route('courses.show', $course->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                View Details
                                            </a>
                                            @admin
                                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="inline-block mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this course?');" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                    Delete
                                                </button>
                                            </form>
                                            @endadmin
                                        </div>
                                    @endforeach
                                </div>
                                {{ $hndCourses->appends(['search' => request('search')])->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
