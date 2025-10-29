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
            <p class="text-4xl font-extrabold text-green-400 mt-2">{{ $RegisteredUsersCount }}</p>
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

    <div class="flex flex-row justify-between items-center mb-4 mt-6">
        <h2 class="text-2xl font-bold text-white">Certificates</h2>
        <a href="{{ route('certificate.create', $event->id) }}" class="px-4 py-2 bg-purple-500 rounded-lg">Generate
            Cercitificate</a>
    </div>
    <div class="rounded-xl shadow-lg overflow-hidden border border-zinc-700 mb-5">
        <table class="min-w-full">
            <thead style="background-color: rgba(255, 255, 255, 0.05);">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Token Count
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Preview
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Created at
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
                @forelse ($allCertificate as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $item->certificate_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            @if ($item->path)
                                <img src="{{ asset('storage/' . $item->path) }}" alt="Certificate Preview"
                                    class="w-32 h-32 object-cover border border-gray-700 rounded-lg shadow-sm hover:scale-105 transition duration-200">
                            @else
                                <span class="text-gray-400">No file</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $item->created_at }}</td>
                        <td class="px-6 py-4 text-sm font-medium space-x-4">
                            <a href="" class="text-yellow-400 hover:text-yellow-300">Edit</a>
                            <a href="" class="text-blue-400 hover:text-blue-300">View</a>
                            <form
                                action="{{ route('certificate.delete', ['event_id' => $event->id, 'certificate_id' => $item->id]) }}"
                                method="POST" onsubmit="return confirm('Are you sure you want to delete this certificate?');"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-6 text-center whitespace-nowrap text-sm text-zinc-400">No Certificate
                            Yet </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <h2 class="text-2xl font-bold text-white mb-4">All Users Registration</h2>

    <!-- Search Bar -->
    <form method="GET" action="{{ route('events.show', $event->id) }}" class="mb-4 flex items-center justify-between">
        <div class="relative w-full max-w-xs">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                class="w-full pl-10 pr-4 py-2 bg-zinc-800 border border-zinc-700 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </div>
    </form>

    <!-- Tables -->
    <div class="rounded-xl shadow-lg overflow-hidden border border-zinc-700">
        <table class="min-w-full">
            <thead class="bg-primary">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Registered
                        At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($RegisteredUsers as $item)
                    <tr class="">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            <a href="{{ route('user.show', $item->user->id ?? '-') }}"
                                class="hover:underline">{{ $item->user->name ?? '-' }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $item->user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white flex flex-col">
                            {{ $item->created_at->format('d-m-Y H:i') }}
                            <span class="text-xs text-zinc-500">{{ $item->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $RegisteredUsers->links() }}

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