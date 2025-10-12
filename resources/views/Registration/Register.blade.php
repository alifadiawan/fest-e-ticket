<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center relative">
    <div class="absolute inset-0">
        <img src="https://futurepreneursummit.com/build/assets/bg-slider-DVH2vyx0.webp" alt="Background"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    <div id="registrationCard" class="w-80 lg:min-w-lg my-12 px-6 py-8 
         bg-white border border-white/30 
         rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] 
         z-10 text-center transition-all duration-500 ease-out">

        <div class="relative mb-12 flex justify-center">
            <img src="https://futurepreneursummit.com/build/assets/Logo-FEST-LIGHT-BTlW9aSe.png" alt="Logo"
                class="relative z-10 scale-95 transition-transform duration-300" />
        </div>

        <h1 class="text-xl font-bold mb-4">Complete Your Registration</h1>

        <form method="POST" action="{{ route('google.register.store') }}" class="mx-auto py-6 sm:px-6 md:max-w-lg">
            @csrf
            @method('POST')

            <div class="mb-5">
                <label class="text-start block text-sm font-medium text-gray-700 mb-2">Token</label>
                <input type="text"
                    class="w-full text-zinc-400 border border-gray-300 rounded-lg p-3 bg-gray-50 cursor-not-allowed focus:outline-none text-sm"
                    name="token_id" value="{{ $googleData['token'] ?? session('registration_token_custom', '') }}"
                    readonly>
                @if(empty($googleData['token']) && empty(session('registration_token_custom')))
                    <p class="text-red-500 text-xs mt-2 flex items-start">
                        <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Token not found. Please start registration from the event page.
                    </p>
                @endif
            </div>

            <div class="mb-5">
                <label class="text-start block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ $googleData['email'] }}" readonly
                    class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 text-zinc-400 text-sm focus:outline-none cursor-not-allowed"
                    readonly>
            </div>

            <div class="mb-5">
                <div class="flex flex-col text-start label mb-2">
                    <label for="nama" class="block text-sm font-semibold text-gray-800 mb-1">
                        Nama
                    </label>
                    <p class="text-xs text-gray-400">
                        Nama ini akan dicetak pada sertifikat. Pastikan penulisan sudah benar. <span
                            class="text-red-500">*</span>
                    </p>
                </div>
                <input type="text" name="name" value="{{ $googleData['name'] }}"
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">
            </div>

            <div class="mb-5 text-start">
                <label for="campus-select" class="block text-sm font-medium text-gray-700 mb-2">
                    Kampus <span class="text-red-500">*</span>
                </label>

                <input list="campus-list" id="campus-select" name="asal_kampus" value="{{ old('asal_kampus') }}"
                    required placeholder="Ketik atau pilih nama kampus"
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow">

                <datalist id="campus-list">
                    @foreach($campus as $item)
                        <option value="{{ $item->campus_name }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="mb-6">
                <div class="flex flex-col text-start label mb-2">
                    <label for="no_telp" class="block text-sm font-semibold text-gray-800 mb-1">
                        No. Telepon
                    </label>
                    <p class="text-xs text-gray-400">
                        Pastikan nomor telepon aktif agar kami bisa menghubungi Anda jika ada pertanyaan atau informasi
                        penting.
                        <span class="text-red-500">*</span>
                    </p>
                </div>
                <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                    class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                    required placeholder="0831...">
                @error('no_telp')
                    <p class="text-red-500 text-xs mt-2 flex items-start">
                        <svg class="w-4 h-4 mr-1 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Token ID harus dibawa, bisa hidden input --}}
            <input type="hidden" name="token_id" value="{{ session('registration_token_custom') }}">

            <button type="submit"
                class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium text-sm transition-all duration-200 active:scale-98 shadow-sm">
                Claim E-Ticket
            </button>
        </form>

    </div>
</body>

</html>