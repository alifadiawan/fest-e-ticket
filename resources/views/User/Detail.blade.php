@extends('Layouts.Main')
@section('page-title', $user->name)
@section('content')

    <div class="card bg-primary text-white p-6 rounded-2xl shadow-md mb-12">
        <!-- Top Section: Basic Info + Action -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <!-- Left: User Info -->
            <div>
                <h1 class="text-2xl font-semibold mb-1">{{ $user->email }}</h1>
                <p class="text-sm text-zinc-400 mb-4">
                    Akun dibuat pada: <span class="text-zinc-300">{{ $user->created_at->format('d M Y') }}</span>
                </p>

                <div class="space-y-1 text-base">
                    <p><span class="text-zinc-400">No. Telp:</span> {{ $user->no_telp }}</p>
                    <p><span class="text-zinc-400">Kampus:</span> {{ $user->asal_kampus ?? '-' }}</p>
                </div>
            </div>

            <!-- Right: Quick Actions -->
            <div class="flex flex-col md:items-end gap-3">
                <div class="flex flex-wrap gap-2">
                    <a href="https://wa.me/+62{{ $user->no_telp }}" target="_blank"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg border border-green-500 text-green-400 hover:bg-green-500 hover:text-white transition">
                        <x-lucide-message-circle class="h-5 w-5" />
                        Whatsapp
                    </a>

                    <a href="mailto:{{ $user->email }}" target="_blank"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg border border-accent text-accent hover:bg-accent hover:text-white transition">
                        <x-lucide-mail class="h-5 w-5" />
                        Email
                    </a>
                </div>

                <div class="flex flex-wrap gap-2 mt-2">
                    <button onclick="navigator.clipboard.writeText('{{ $user->email }}')"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-zinc-700 hover:bg-zinc-600 transition text-sm">
                        <x-lucide-copy class="h-4 w-4" />
                        Copy Email
                    </button>

                    <button onclick="navigator.clipboard.writeText('https://wa.me/+62{{ $user->no_telp }}')"
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-zinc-700 hover:bg-zinc-600 transition text-sm">
                        <x-lucide-copy class="h-4 w-4" />
                        Copy WhatsApp Link
                    </button>

                    <a href=""
                        class="flex items-center gap-2 px-4 py-2 rounded-lg bg-accent transition text-sm text-zinc-800">
                        <x-lucide-pencil class="h-4 w-4" />
                        Edit User
                    </a>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-zinc-700 my-6"></div>

        <!-- Warning Section -->
        <div class="text-sm text-zinc-400">
            <span class="text-red-500">*</span> Mengirim pesan manual dengan WhatsApp dapat berujung pemblokiran nomor
            pengirim dari Facebook. Gunakan dengan bijak.
            <a href="https://faq.whatsapp.com/465883178708358/?helpref=hc_fnav" target="_blank"
                class="underline hover:text-zinc-300 ml-1">Baca disini</a>
        </div>
    </div>


    <h1 class="font-bold text-2xl mb-5 ">Event Terdaftar</h1>
    <div class="rounded-xl shadow-lg overflow-hidden border border-zinc-700">
        <table class="min-w-full">
            <thead style="background-color: rgba(255, 255, 255, 0.05);">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Event
                        Name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Token
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Registered
                        at
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-700">
                @foreach ($pastEvent as $item)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-sm text-white font-medium">{{ $item->event->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">{{ $item->token->token }}</td>
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y H:i') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection