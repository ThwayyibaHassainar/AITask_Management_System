@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto bg-slate-800 p-8 rounded-xl shadow">

    <h1 class="text-2xl font-bold mb-6">
        {{ isset($task) ? 'Edit Task' : 'Create Task' }}
    </h1>

    <form method="POST"
          action="{{ isset($task) ? route('tasks.update',$task->id) : route('tasks.store') }}">
        @csrf
        @if(isset($task))
            @method('PUT')
        @endif

        <!-- Title -->
        <div class="mb-5">
            <label class="block mb-2 text-gray-400">Title</label>
            <input type="text"
                   name="title"
                   value="{{ old('title',$task->title ?? '') }}"
                   class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2 focus:ring-indigo-500 focus:outline-none">
        </div>

        <!-- Description -->
        <div class="mb-5">
            <label class="block mb-2 text-gray-400">Description</label>
            <textarea name="description"
                      rows="4"
                      class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2">{{ old('description',$task->description ?? '') }}</textarea>
        </div>

        <!-- Priority -->
        <div class="mb-5">
            <label class="block mb-2 text-gray-400">Priority</label>
            <select name="priority"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        <!-- Due Date -->
        <div class="mb-5">
            <label class="block mb-2 text-gray-400">Due Date</label>
            <input type="date"
                   name="due_date"
                   value="{{ old('due_date',$task->due_date ?? '') }}"
                   class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2">
        </div>

        <!-- Assigned User -->
        <div class="mb-5">
            <label class="block mb-2 text-gray-400">Assign To</label>
            <select name="assigned_to"
                    class="w-full bg-slate-700 border border-slate-600 rounded-lg px-4 py-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="bg-indigo-600 hover:bg-indigo-700 px-6 py-2 rounded-lg font-medium">
            Save Changes
        </button>

    </form>

</div>

@endsection