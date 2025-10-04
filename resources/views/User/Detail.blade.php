@extends('Layouts.Main')
@section('page-title', $user->name)
@section('content')

    <div class="card bg-primary p-6 rounded-xl mb-12">

        <div class="first mb-12">
            <h1 class="font-bold text-2xl">{{ $user->email }}</h1>
            <p class="text-zinc-500">Akun dibuat pada Tanggal : {{ $user->created_at }}</p>

        </div>
        <div class="second mb-12">
            <p>{{ $user->no_telp }}</p>
            <p>{{ $user->asal_kampus ?? '-' }}</p>
        </div>

        <div class="third flex flex-row gap-2 mb-2">
            <a href="https://wa.me/+62{{ $user->no_telp }}" target="_blank"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border border-green-500 text-green-600 hover:bg-green-500 hover:text-white transition">
                <x-lucide-message-circle class="h-5 w-5" />
                Whatsapp
                <x-lucide-arrow-up-right class="h-4 w-4 opacity-70" />
            </a>

            <a href="mailto:{{ $user->email }}" target="_blank"
                class="flex items-center gap-2 px-4 py-2 rounded-lg border border-accent text-accent hover:bg-accent hover:text-white transition">
                <x-lucide-mail class="h-5 w-5" />
                Email
                <x-lucide-arrow-up-right class="h-4 w-4 opacity-70" />
            </a>
        </div>

        <div class="warning">
            <p class="text-sm text-zinc-500">
                <span class="text-red-500 text-xs">*</span>
                Mengirim pesan manual dengan Whatsapp dapat berujung pemblokiran nomor pengirim dari Facebook. Gunakan dengan bijak !
                <br>
                <a href="https://faq.whatsapp.com/465883178708358/?helpref=hc_fnav" target="_blank" class="underline hover:text-zinc-400">baca disini</a>
            </p>
        </div>

    </div>

    <div class="card bg-primary p-6 rounded-xl">
        <h1 class="font-bold text-2xl">Event Terdaftar</h1>
    </div>

@endsection