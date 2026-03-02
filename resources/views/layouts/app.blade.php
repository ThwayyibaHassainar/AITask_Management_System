<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('taskChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                datasets: [{
                    label: 'Tasks',
                    data: [12, 19, 8, 14, 10],
                    backgroundColor: '#3b82f6'
                }]
            }
        });
    }
</script>

<body class="bg-slate-900 text-gray-200 min-h-screen">

    <div class="flex min-h-screen">

        <!-- Main Content -->
        <main class="flex-1 p-6 md:p-10">
            <div class="flex gap-8">

                <!-- Main Content -->
                <div class="flex-1">
                    @yield('content')
                </div>

                <!-- Right Dashboard Panel -->
                @php
                    $user = auth()->user();
                @endphp

                {{-- @if ($user && $user->role === 'admin')
                    <div class="right-panel bg-white p-4 rounded-lg shadow">
                        <!-- Admin content here -->
                        <h4 class="font-semibold mb-2">Admin Panel</h4>
                        <p>Only visible to admins.</p>
                    </div>
                @endif --}}
                @auth
                    <div class="hidden lg:block w-80">
                        @include('layouts.partials.right-panel')
                    </div>
                @endauth

            </div>
        </main>

    </div>

</body>

</html>
