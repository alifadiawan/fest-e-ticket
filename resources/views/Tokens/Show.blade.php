@extends('Layouts.Main')
@section('page-title', 'Tokens for : ' . $tokendetail[0]->event->name)
@section('back', true)
@section('content')

    <!-- Search bar -->
    <form method="GET" action="{{ url()->current() }}" class="mb-4 flex items-center justify-between">
        <div class="relative w-full max-w-md">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Search token, user name, or email..."
                class="w-full pl-10 pr-4 py-2 bg-zinc-800 border border-zinc-700 text-white rounded-xl focus:outline-none focus:ring-2 focus:ring-primary placeholder-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
            </svg>
        </div>
    </form>

    <div class="rounded-xl shadow-lg overflow-hidden border border-zinc-700">
        <table class="min-w-full">
            <thead class="bg-primary">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Token</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Used By
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Used At
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Created At
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tokendetail as $item)
                    <tr class="">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white font-mono">{{ $item->token }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span
                                class="px-2 py-1 rounded text-xs font-medium
                                                    {{ $item->status === 'unused' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            <a href="{{ route('user.show', $item->user->id ?? '-') }}"
                                class="hover:underline">{{ $item->user->name ?? '-' }}</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white">
                            {{ $item->used_at ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-white flex flex-col">
                            {{ $item->created_at->format('d-m-Y H:i') }}
                            <span class="text-xs text-zinc-500">{{ $item->created_at->diffForHumans() }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{ $tokendetail->links() }}


@endsection