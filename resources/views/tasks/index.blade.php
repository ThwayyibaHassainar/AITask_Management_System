@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-bold text-white">Task List</h1>
            <p class="text-gray-400 mt-2">Manage and track your tasks efficiently</p>
        </div>

        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('tasks.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                    + New Task
                </a>
            @endif
        @endauth
    </div>

    <!-- Filters -->
    <form method="GET" class="flex gap-4 mb-8">

        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks..."
            class="bg-white text-gray-800 px-4 py-2 rounded-xl w-64">

        <select name="status" class="bg-white text-gray-800 px-4 py-2 rounded-xl">
            <option value="">Status</option>
            <option value="pending" @selected(request('status') == 'pending')>Pending</option>
            <option value="completed" @selected(request('status') == 'completed')>Completed</option>
        </select>

        <select name="priority" class="bg-white text-gray-800 px-4 py-2 rounded-xl">
            <option value="">Priority</option>
            <option value="low" @selected(request('priority') == 'low')>Low</option>
            <option value="medium" @selected(request('priority') == 'medium')>Medium</option>
            <option value="high" @selected(request('priority') == 'high')>High</option>
        </select>

        <button class="bg-blue-500 text-white px-6 py-2 rounded-xl">
            Filter
        </button>

    </form>

    <!-- Task Cards Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">


        @foreach ($tasks as $task)
            <div class="bg-gray-100 rounded-3xl p-6 shadow-md hover:shadow-xl transition duration-300">

                <!-- Top Row -->
                <div class="flex justify-between items-center mb-5">

                    <!-- Status with icon -->
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 rounded-full bg-blue-500 flex items-center justify-center">
                            <div class="w-2 h-2 bg-white rounded-full"></div>
                        </div>

                        <span class="text-sm font-medium text-gray-600 bg-gray-200 px-3 py-1 rounded-full">
                            {{ ucfirst(str_replace('_', ' ', $task->status->value)) }}
                        </span>
                    </div>

                    <!-- 3 dots -->
                    <div class="text-gray-400 text-xl cursor-pointer">
                        ⋯
                    </div>
                </div>


                <!-- Title -->
                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    {{ $task->title }}
                </h3>


                <!-- Badges Row -->
                <div class="flex items-center gap-3 mb-4">

                    <!-- Small Status Pill -->
                    <span class="text-xs px-3 py-1 rounded-full bg-gray-200 text-gray-600">
                        Status
                    </span>

                    <!-- Priority Pill -->
                    <span
                        class="text-xs px-3 py-1 rounded-full font-medium
            {{ $task->priority->value == 'high'
                ? 'bg-red-500 text-white'
                : ($task->priority->value == 'medium'
                    ? 'bg-yellow-400 text-white'
                    : 'bg-green-500 text-white') }}">
                        Priority {{ ucfirst($task->priority->value) }}
                    </span>
                    {{-- <span class="text-xs px-3 py-1 rounded-full font-medium {{ $task->priority->color() }}">
    Priority {{ ucfirst($task->priority->value) }}
</span> --}}
                </div>


                <!-- Description Box -->
                <div class="bg-gray-200 rounded-xl p-4 mb-5">
                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                        {{ $task->description }}
                    </p>
                </div>


                <!-- Bottom Actions -->
                <div class="flex justify-end gap-3">

                    <a href="{{ route('tasks.edit', $task->id) }}"
                        class="px-5 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-full text-sm font-medium transition">
                        Edit
                    </a>

                    <a href="{{ route('tasks.show', $task->id) }}"
                        class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full text-sm font-medium transition">
                        View
                    </a>

                </div>

            </div>
        @endforeach

    </div>

    <a href="{{ route('tasks.index') }}" class="mt-4 px-4 py-2 bg-gray-400 text-white rounded-xl inline-block">
        Reset
    </a>

    <!-- Pagination -->
    <div class="mt-10">
        {{ $tasks->links() }}
    </div>
@endsection
