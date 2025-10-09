@extends('Layouts.Main')
@section('page-title', $event->name)
@section('back', true)
@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('loading'))
        <div class="flex items-center gap-3 p-4 mb-4 text-blue-800 bg-blue-100 rounded-lg border border-blue-200" role="alert">
            <!-- Spinner -->
            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>

            <!-- Message -->
            <span>{{ session('loading') }}</span>
        </div>

        <script>
            setTimeout(() => {
                location.reload();
            }, 3000); // refresh every 3 seconds
        </script>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <div class="rounded-xl shadow-lg p-6 text-center bg-primary">
            <h2 class="text-lg font-semibold text-gray-400">Total Tokens</h2>
            <p class="text-4xl font-extrabold text-indigo-400 mt-2">{{ $TotalToken }}</p>
        </div>
        <div class="rounded-xl shadow-lg p-6 text-center bg-primary">
            <h2 class="text-lg font-semibold text-gray-400">Registered Users</h2>
            <p class="text-4xl font-extrabold text-green-400 mt-2">{{ $RegisteredUsers }}</p>
        </div>
        <div class="rounded-xl shadow-lg p-6 text-center bg-primary">
            <h2 class="text-lg font-semibold text-gray-400">Tokens Claimed</h2>
            <p class="text-4xl font-extrabold text-yellow-400 mt-2">{{ $TokenClaimed }}</p>
        </div>
    </div>

    <div class="flex flex-col mb-12 items-start">
        <h2 class="text-2xl font-bold text-white mb-4">Ticket Design</h2>
        <div class="w-[778px] h-[224px] overflow-hidden flex items-center justify-center">
            <img src="{{ asset('storage/' . $event->{'custom_ticket_pict'}) }}"
                class="h-[778px] w-[224px] -rotate-90 object-contain rounded-xl" alt="E-Ticket">
        </div>
    </div>


    <div class="flex flex-row justify-between mb-4">
        <h2 class="text-2xl font-bold text-white">Tokens History</h2>
        <a onclick="openModal('exampleModal')" class="px-4 py-2 bg-purple-500 rounded-lg">Generate Token</a>
    </div>
    <div class="rounded-xl shadow-lg overflow-hidden border border-zinc-700">
        <table class="min-w-full">
            <thead style="background-color: rgba(255, 255, 255, 0.05);">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Token Count
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Created at
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
                @forelse ($TokenHistory as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $item->count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $item->created_at }}</td>
                        <td class="px-6 py-4 text-sm font-medium space-x-4">
                            <a href="{{ route('tokens.show', ['event_id' => $event->id, 'batch_id' => $item->id]) }}"
                                class="text-blue-400 hover:text-blue-300">View</a>
                            <a href="{{ route('tokens.download', ['event_id' => $event->id, 'batch_id' => $item->id]) }}"
                                class="text-green-400 hover:text-blue-300">Download</a>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center whitespace-nowrap text-sm text-zinc-400">No Token
                            Generated Yet </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- <table class="min-w-full  mb-4">
                    <thead style="background-color: rgba(255, 255, 255, 0.05);">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Token Count
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-700" style="border-color: var(--color-border);">
                        @forelse ($TokenHistory as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $item->count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $item->created_at }}</td>
                                <td class="px-6 py-4 text-sm font-medium space-x-4">
                                    <a href="{{ route('tokens.show', ['event_id' => $event->id, 'batch_id' => $item->id]) }}"
                                        class="text-blue-400 hover:text-blue-300">View</a>
                                    <a href="{{ route('tokens.download', ['event_id' => $event->id, 'batch_id' => $item->id]) }}"
                                        class="text-green-400 hover:text-blue-300">Download</a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-6 text-center whitespace-nowrap text-sm text-zinc-400">No Token
                                    Generated Yet </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table> -->


    <h2 class="text-2xl font-bold text-white mb-4 mt-4">Analytics</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <div class="rounded-xl p-6 bg-primary">
            <h3 class="text-lg font-semibold text-gray-300 mb-4">User Registrations (Last 7 Days)</h3>
            <div class="w-full h-64 flex items-end justify-between space-x-2">
                <div class="w-1/6 h-1/3 bg-green-500 rounded-t-md opacity-75"></div>
                <div class="w-1/6 h-2/3 bg-green-500 rounded-t-md"></div>
                <div class="w-1/6 h-1/2 bg-green-500 rounded-t-md opacity-75"></div>
                <div class="w-1/6 h-3/4 bg-green-500 rounded-t-md"></div>
                <div class="w-1/6 h-2/5 bg-green-500 rounded-t-md opacity-75"></div>
                <div class="w-1/6 h-5/6 bg-green-500 rounded-t-md"></div>
                <div class="w-1/6 h-1/2 bg-green-500 rounded-t-md opacity-75"></div>
            </div>
        </div>
        <div class="rounded-xl p-6 bg-primary">
            <h3 class="text-lg font-semibold text-gray-300 mb-4">Token Claim Rate</h3>
            <div class="w-full h-64">
                <svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 200 100"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M 10 80 C 40 20, 60 20, 90 60 S 150 100, 190 70" class="stroke-indigo-400"></path>
                    <circle cx="10" cy="80" r="2" class="fill-indigo-400"></circle>
                    <circle cx="90" cy="60" r="2" class="fill-indigo-400"></circle>
                    <circle cx="190" cy="70" r="2" class="fill-indigo-400"></circle>
                </svg>
            </div>
        </div>
    </div>

    <h2 class="text-2xl font-bold text-white mb-4">Recent Registrations</h2>
    <div class="rounded-xl overflow-hidden" border: 1px solid var(--color-border);">
        <table class="min-w-full">
            <thead style="background-color: rgba(255, 255, 255, 0.05);">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Registered
                        At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700" style="border-color: var(--color-border);">
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">1</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Aria Montgomery</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">aria.m@email.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">2025-09-18</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">2</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Spencer Hastings</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">spencer.h@email.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">2025-09-18</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">3</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Hanna Marin</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">hanna.m@email.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">2025-09-17</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">4</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Emily Fields</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">emily.f@email.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">2025-09-16</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">5</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-white">Caleb Rivers</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">caleb.r@email.com</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">2025-09-15</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- generate token --}}
    <x-modal id="exampleModal" title="Event Details">
        <form action="{{ route('generate.token', $event->id) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="count" class="block text-sm font-medium text-gray-300">Number of Tokens</label>
                <input type="number" name="count" id="count"
                    class="w-full mt-1 p-2 rounded bg-primary text-white border border-gray-600" value="25000" min="1"
                    required>
            </div>

            <div class="mb-4">
                <label for="length" class="block text-sm font-medium text-gray-300">Token Length</label>
                <input type="number" name="length" id="length"
                    class="w-full mt-1 p-2 rounded bg-primary text-white border border-gray-600" value="8" min="4" max="32"
                    required>
            </div>

            <button type="submit"
                class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 rounded-lg text-white font-semibold">
                Generate Tokens
            </button>
        </form>
    </x-modal>


@endsection