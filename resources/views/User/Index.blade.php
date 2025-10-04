@extends('Layouts.Main')
@section('page-title', 'Users')
@section('content')

    <!-- Status Card -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6 mb-8">
        <div class="rounded-xl shadow-lg p-6 bg-primary">
            <h2 class="text-lg font-semibold text-gray-400">Total Users</h2>
            <p class="text-4xl font-extrabold text-indigo-400 mt-2">5</p>
        </div>
        <div class="rounded-xl shadow-lg p-6 bg-primary">
            <h2 class="text-lg font-semibold text-gray-400">Recurring Users</h2>
            <p class="text-4xl font-extrabold text-green-400 mt-2">3</p>
        </div>
    </div>

    <div class="rounded-xl shadow-lg overflow-hidden border border-zinc-700">
        <table class="min-w-full">
            <thead style="background-color: rgba(255, 255, 255, 0.05);">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">No Telp
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Asal Kampus
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
                @foreach ($users as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-white font-medium">{{ $item->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $item->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ $item->no_telp ? str_repeat('*', strlen($item->no_telp) - 3) . substr($item->no_telp, -3) : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $item->asal_kampus }}</td>

                        <td class="px-6 py-4 text-sm font-medium space-x-4">
                            <a href="{{ route('user.show', $item->id) }}" class="text-blue-400 hover:text-blue-300">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



@endsection