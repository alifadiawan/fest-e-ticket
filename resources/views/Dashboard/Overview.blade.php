@extends('Layouts.Main')
@section('content')
    <div class="container">

        {{-- Welcome message --}}
        <h1 class="font-bold text-4xl">Selamat Malam, Alif Adiawan</h1>

        {{-- cards overview --}}
        <div class="flex flex-row gap-5 flex-wrap mt-5">
            <!-- Total Events Card -->
            <div class="bg-gradient-to-br from-primary-light to-primary rounded-2xl shadow-lg p-6 w-62 transform transition flex ">
                <div class="mr-4 flex items-center">
                    <!-- Calendar Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-accent" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm">Total Events</h3>
                    <p class="text-white font-bold text-2xl mt-2">{{ $totalEvent }}</p>
                </div>
            </div>

            <!-- Tickets Sold Card -->
            <div class="bg-gradient-to-br from-primary-light to-primary rounded-2xl shadow-lg p-6 w-62 transform transition flex ">
                <div class="mr-4 flex items-center">
                    <!-- Ticket Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-pink-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 20l-5-5 5-5m6 10l5-5-5-5" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm">Tickets Sold</h3>
                    <p class="text-white font-bold text-2xl mt-2">{{ $totalTokens }}</p>
                </div>
            </div>

            <!-- Revenue Card -->
            <div class="bg-gradient-to-br from-primary-light to-primary rounded-2xl shadow-lg p-6 w-62 transform transition flex ">
                <div class="mr-4 flex items-center">
                    <!-- Dollar Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 1.343-3 3s1.343 3 3 3m0-6v6m0 6v2m0-16V4m-6 6H4m16 0h-2" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm">Revenue</h3>
                    <p class="text-white font-bold text-2xl mt-2">-</p>
                </div>
            </div>

            <!-- Active Users Card -->
            <div class="bg-gradient-to-br from-primary-light to-primary rounded-2xl shadow-lg p-6 w-62 transform transition flex ">
                <div class="mr-4 flex items-center">
                    <!-- Users Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2h5m0-6a4 4 0 100-8 4 4 0 000 8zm10 0a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-gray-400 text-sm">Active Users</h3>
                    <p class="text-white font-bold text-2xl mt-2">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <h1 class="font-bold text-2xl mt-12">Ongoing Events</h1>
        <div class="shadow-lg mt-8">


            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $item)
                    <!-- Event Card -->
                    <a href="{{ route('events.show', $item->id) }}">
                        <div class="bg-black rounded-xl min-h-full shadow hover:scale-103 transform transition">
                            <div class="flex flex-col bg-secondary p-4 rounded-t-xl">
                                <h4 class="text-white font-bold text-lg">{{ $item->name }}</h4>
                                <p class="text-gray-400 text-sm">{{ $item->location }}</p>
                            </div>

                            <div class="content p-4">
                                <!-- Progress -->
                               @php
                                    $progress = $item->total_tokens > 0
                                        ? round(($item->claimed_tokens / $item->total_tokens) * 100, 2)
                                        : 0;
                                @endphp
                                <div class="mt-2">
                                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                                        <span>Tickets Sold</span>
                                        <span>{{ $progress }} %</span>
                                    </div>
                                    <div class="w-full h-2 bg-gray-700 rounded-full">
                                        <div class="h-2 bg-accent rounded-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>
    
                                <div class="mt-4 flex justify-between text-sm text-gray-300">
                                    <span>🎟️ {{ $item->claimed_tokens }} / {{ $item->total_tokens }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>

        <h1 class="font-bold text-2xl mt-12">Penjualan Tiket</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <!-- Chart Card -->
            <div class="bg-primary border-l-4 border-accent rounded-2xl shadow-lg p-6">
                <h3 class="text-gray-400 text-sm mb-4">Weekly Ticket Sales</h3>
                <canvas id="ticketsChart" class="w-full h-64"></canvas>
            </div>

            <!-- Table Card -->
            <div class="bg-primary border-l-4 border-pink-500 rounded-2xl shadow-lg p-6">
                <h3 class="text-gray-400 text-sm mb-4">Top Events</h3>
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-gray-400 border-b border-gray-700">
                            <th class="pb-2">Event</th>
                            <th class="pb-2">Tickets</th>
                            <th class="pb-2">Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-white border-b border-gray-800 hover:bg-gray-800/50">
                            <td class="py-2">Music Festival</td>
                            <td>1200</td>
                            <td>$24,000</td>
                        </tr>
                        <tr class="text-white border-b border-gray-800 hover:bg-gray-800/50">
                            <td class="py-2">Tech Summit</td>
                            <td>850</td>
                            <td>$17,500</td>
                        </tr>
                        <tr class="text-white border-b border-gray-800 hover:bg-gray-800/50">
                            <td class="py-2">Startup Meetup</td>
                            <td>400</td>
                            <td>$8,000</td>
                        </tr>
                        <tr class="text-white border-b border-gray-800 hover:bg-gray-800/50">
                            <td class="py-2">Food Expo</td>
                            <td>650</td>
                            <td>$13,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="bg-primary border-l-4 border-accent rounded-2xl shadow-lg p-6 mt-8">
            <h3 class="text-gray-400 text-sm mb-4">Latest Transactions</h3>

            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-gray-400 border-b border-gray-700">
                        <th class="pb-2">User</th>
                        <th class="pb-2">Event</th>
                        <th class="pb-2">Amount</th>
                        <th class="pb-2">Status</th>
                        <th class="pb-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-white border-b border-gray-800 hover:bg-gray-800/50">
                        <td class="py-2">John Doe</td>
                        <td>Music Festival</td>
                        <td>$120</td>
                        <td><span class="text-green-400 font-semibold">Paid</span></td>
                        <td>2025-09-11 21:15</td>
                    </tr>
                    <tr class="text-white border-b border-gray-800 hover:bg-gray-800/50">
                        <td class="py-2">Sarah Lee</td>
                        <td>Tech Summit</td>
                        <td>$75</td>
                        <td><span class="text-yellow-400 font-semibold">Pending</span></td>
                        <td>2025-09-11 20:58</td>
                    </tr>
                    <tr class="text-white border-b border-gray-800 hover:bg-gray-800/50">
                        <td class="py-2">Michael Chen</td>
                        <td>Food Expo</td>
                        <td>$45</td>
                        <td><span class="text-green-400 font-semibold">Paid</span></td>
                        <td>2025-09-11 20:30</td>
                    </tr>
                    <tr class="text-white border-b border-gray-800 hover:bg-gray-800/50">
                        <td class="py-2">Aisha Khan</td>
                        <td>Startup Meetup</td>
                        <td>$60</td>
                        <td><span class="text-red-400 font-semibold">Failed</span></td>
                        <td>2025-09-11 19:55</td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('ticketsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Tickets Sold',
                    data: [120, 200, 150, 300, 250, 400, 320],
                    borderColor: '#14b8a6', // accent color
                    backgroundColor: 'rgba(20, 184, 166, 0.2)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            color: '#ccc'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            color: '#888'
                        },
                        grid: {
                            color: '#333'
                        }
                    },
                    y: {
                        ticks: {
                            color: '#888'
                        },
                        grid: {
                            color: '#333'
                        }
                    }
                }
            }
        });
    </script>
@endsection