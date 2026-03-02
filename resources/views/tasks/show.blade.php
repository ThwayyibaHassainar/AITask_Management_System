@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-800 via-slate-900 to-slate-800 py-12">

    <div class="mx-auto space-y-8">

        <!-- Header (Less dominant, faded) -->
        <div>
            <h1 class="text-4xl font-bold text-white/80">
                Task Detail + AI Summary
            </h1>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 space-y-6">

            <!-- Title -->
            <div class="flex justify-between items-start">
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ $task->title }}
                </h2>

                <!-- Pills -->
                <div class="flex gap-3">

                    <span class="text-xs px-3 py-1 rounded-full bg-gray-200 text-gray-700">
                        Status {{ ucfirst($task->status->value) }}
                    </span>

                    <span
                        class="text-xs px-3 py-1 rounded-full font-medium
                        {{ $task->priority->value === 'high'
                            ? 'bg-red-500 text-white'
                            : ($task->priority->value === 'medium'
                                ? 'bg-yellow-400 text-white'
                                : 'bg-green-500 text-white') }}">
                        Priority {{ ucfirst($task->priority->value) }}
                    </span>

                </div>
            </div>

            <!-- Description Box -->
            <div class="bg-gray-50 rounded-xl p-6 space-y-3">
                <h3 class="font-semibold text-gray-700">Description</h3>

                <p class="text-sm text-gray-600">
                    <span class="font-medium">Assigned to:</span>
                    {{ $task->user->name ?? 'Unassigned' }}
                </p>

                <p class="text-sm text-gray-600">
                    <span class="font-medium">Due Date:</span>
                    {{ $task->due_date }}
                </p>

                <p class="text-sm text-gray-600 pt-2">
                    {{ $task->description }}
                </p>
            </div>

            <!-- AI Summary -->
            <div class="bg-gray-100 rounded-xl p-6 space-y-3">
                <h3 class="font-semibold text-gray-700">
                    AI-Generated Summary
                </h3>

                <p class="text-sm text-gray-600">
                    {{ $task->ai_summary ?? 'AI processing pending...' }}
                </p>

                <p class="text-sm text-gray-700 pt-2">
                    <span class="font-semibold">AI Suggested Priority:</span>
                    {{ ucfirst($task->ai_priority->value ?? '-') }}
                </p>
            </div>


        </div>

    </div>

</div>

@endsection