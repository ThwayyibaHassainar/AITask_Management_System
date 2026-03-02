<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="bg-white rounded-3xl shadow-xl p-6">

    <!-- Profile -->
    <div class="flex items-center gap-4 mb-6">
        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" class="w-14 h-14 rounded-full">

        <div>
            <h3 class="font-semibold">{{ auth()->user()->name }}</h3>
            <p class="text-sm text-gray-500 capitalize">
                {{ auth()->user()->role }}
            </p>
        </div>
    </div>



    <!-- Menu -->
    <div class="flex flex-col gap-4 mb-8">

        <a href="{{ route('tasks.index') }}"
            class="block w-full px-4 py-3 rounded-xl bg-blue-500 text-white hover:bg-blue-600 transition">
            Tasks
        </a>

        @if (auth()->user()->isAdmin())
            <a href="{{ route('users.index') }}"
                class="block w-full px-4 py-3 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                Users (Only Visible to Admin)
            </a>
        @endif

        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <button
                class="w-full text-left px-4 py-3 rounded-xl bg-gray-100 text-gray-700 hover:bg-gray-200 transition">
                Logout
            </button>
        </form>

    </div>

    @if (auth()->user()->isAdmin())
        <!-- Stats -->
        <div class="mb-6">
            <h4 class="font-semibold text-gray-700 mb-4">
                Monthly Stats
            </h4>

            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="bg-blue-100 rounded-xl p-3">
                    <p class="text-xl font-bold text-red-600">
                        {{ \App\Models\Task::count() }}
                    </p>
                    <p class="text-xs text-gray-600">Total</p>
                </div>

                <div class="bg-green-100 rounded-xl p-3">
                    <p class="text-xl font-bold text-green-600">
                        {{ \App\Models\Task::where('status', 'completed')->count() }}
                    </p>
                    <p class="text-xs text-gray-600">Done</p>
                </div>

                <div class="bg-yellow-100 rounded-xl p-3">
                    <p class="text-xl font-bold text-yellow-600">
                        {{ \App\Models\Task::where('status', 'pending')->count() }}
                    </p>
                    <p class="text-xs text-gray-600">Pending</p>
                </div>
            </div>
        </div>

        <!-- Chart Placeholder -->
        <div>
            <h4 class="font-semibold text-gray-700 mb-4">
                Monthly Completion
            </h4>
            <canvas id="taskChart" height="150"></canvas>
        </div>
    @endif

</div>


{{-- <div class="hidden lg:block w-80 sticky top-8 self-start"> --}}
