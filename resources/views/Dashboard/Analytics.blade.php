@extends('Layouts.Main')
@section('page-title', 'Analytics')
@section('content')


    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-primary-light rounded-xl p-5 shadow hover:shadow-accent/20 hover:scale-[1.02] transition">
            <h3 class="text-gray-400 text-sm">Unique Users Registered</h3>
            <p class="text-3xl font-bold mt-2 text-white">{{ $uniqueUsers }}</p>
        </div>

        <div class="bg-primary-light rounded-xl p-5 shadow hover:shadow-accent/20 hover:scale-[1.02] transition">
            <h3 class="text-gray-400 text-sm">Token Usage Rate</h3>
            <p class="text-3xl font-bold mt-2 text-white">{{ $tokenUsageRate }}%</p>
        </div>

        <div class="bg-primary-light rounded-xl p-5 shadow hover:shadow-accent/20 hover:scale-[1.02] transition">
            <h3 class="text-gray-400 text-sm">Used Tokens</h3>
            <p class="text-3xl font-bold mt-2 text-white">{{ $usedTokens }} / {{ $totalTokens }}</p>
        </div>

        <div class="bg-primary-light rounded-xl p-5 shadow hover:shadow-accent/20 hover:scale-[1.02] transition">
            <h3 class="text-gray-400 text-sm">Total Events</h3>
            <p class="text-3xl font-bold mt-2 text-white">{{ $topEvents->count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Top 5 Most Registered Events --}}
        <div class="bg-primary-light p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-3 text-accent">Top 5 Most Registered Events</h2>
            <div class="h-72"> {{-- fixed height container --}}
                <canvas id="topEventsChart"></canvas>
            </div>
        </div>

        {{-- Token Use by Event --}}
        <div class="bg-primary-light p-6 rounded-xl shadow">
            <h2 class="text-lg font-semibold mb-3 text-accent">Token Use by Event</h2>
            <div class="h-72"> {{-- fixed height container --}}
                <canvas id="tokenUseChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Token Usage Pie --}}
    <div class="bg-primary-light p-6 rounded-xl shadow mt-8 max-w-md mx-auto">
        <h2 class="text-lg font-semibold mb-3 text-center text-accent">Overall Token Usage</h2>
        <div class="h-72">
            <canvas id="tokenUsagePie"></canvas>
        </div>
    </div>


    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Top 5 Most Registered Events
        const topEvents = @json($topEvents->pluck('name'));
        const topEventCounts = @json($topEvents->pluck('registrations_count'));

        new Chart(document.getElementById('topEventsChart'), {
            type: 'bar',
            data: {
                labels: topEvents,
                datasets: [{
                    label: 'Registrations',
                    data: topEventCounts,
                    backgroundColor: '#3b82f6'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Token Use by Event
        const tokenEventNames = @json($tokenUseByEvent->pluck('name'));
        const usedTokens = @json($tokenUseByEvent->pluck('used_tokens'));
        const totalTokens = @json($tokenUseByEvent->pluck('total_tokens'));

        new Chart(document.getElementById('tokenUseChart'), {
            type: 'bar',
            data: {
                labels: tokenEventNames,
                datasets: [
                    {
                        label: 'Used Tokens',
                        data: usedTokens,
                        backgroundColor: '#22c55e'
                    },
                    {
                        label: 'Total Tokens',
                        data: totalTokens,
                        backgroundColor: '#e5e7eb'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Token Usage Pie
        new Chart(document.getElementById('tokenUsagePie'), {
            type: 'doughnut',
            data: {
                labels: ['Used', 'Unused'],
                datasets: [{
                    data: [{{ $usedTokens }}, {{ $totalTokens - $usedTokens }}],
                    backgroundColor: ['#10b981', '#f87171']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    </script>


@endsection