@extends('Layouts.Main')
@section('content')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="rounded-xl shadow-lg p-6 bg-primary">
            <h2 class="text-lg font-semibold text-gray-400">Total Events</h2>
            <p class="text-4xl font-extrabold text-indigo-400 mt-2">5</p>
        </div>
        <div class="rounded-xl shadow-lg p-6 bg-primary">
            <h2 class="text-lg font-semibold text-gray-400">Upcoming Events</h2>
            <p class="text-4xl font-extrabold text-green-400 mt-2">3</p>
        </div>
        <div class="rounded-xl shadow-lg p-6 bg-primary">
            <h2 class="text-lg font-semibold text-gray-400">Past Events</h2>
            <p class="text-4xl font-extrabold text-gray-500 mt-2">2</p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                        d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
            </span>
        </div>
    @endif

    <h2 class="text-2xl font-bold text-white mb-4">All Events</h2>

    <a href="{{ route('events.create') }}" class="px-4 py-2 bg-primary rounded-lg">Create Event</a>

    <div class="rounded-xl shadow-lg overflow-hidden border border-zinc-700 mt-6">
        <table class="min-w-full">
            <thead style="background-color: rgba(255, 255, 255, 0.05);">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Event Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Location
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
                @foreach ($events as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-white font-medium">{{ $item->name }}</td>
                        <td class="px-6 py-4 text-sm text-white font-medium">{{ $item->location ?? '-' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $item->created_at }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if ($item->status == 'draft')
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold leading-5 rounded-full bg-orange-900 text-orange-300">Draft</span>
                            @elseif ($item->status == 'upcoming')
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold leading-5 rounded-full bg-yellow-900 text-yellow-300">Upcoming</span>
                            @elseif ($item->status == 'published')
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold leading-5 rounded-full bg-green-900 text-green-300">Published</span>
                            @elseif ($item->status == 'passed')
                                <span
                                    class="px-2.5 py-1 text-xs font-semibold leading-5 rounded-full bg-gray-900 text-gray-300">Passed</span>
                            @endif

                        </td>
                        <td class="px-6 py-4 text-sm font-medium space-x-4">
                            <a href="{{ route('events.show', $item->id) }}" class="text-blue-400 hover:text-blue-300">View</a>
                            <a href="{{ route('events.edit', $item->id) }}" class="text-purple-400 hover:text-blue-300">Edit</a>
                            <form action="{{ route('events.delete', $item->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this event?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ms-5 text-zinc-700 hover:text-red-500 font-semibold">
                                    Trash
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection