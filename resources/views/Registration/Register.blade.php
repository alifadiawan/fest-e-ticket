<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center relative overflow-hidden">
    <div class="absolute inset-0">
        <img src="https://futurepreneursummit.com/build/assets/bg-slider-DVH2vyx0.webp" alt="Background"
            class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    <div id="registrationCard"
        class="relative w-96 pb-6 px-6 pt-0 bg-white rounded-xl shadow-lg z-10 text-center transition-all duration-700 ease-in-out opacity-100 scale-100">

        <div class="relative mb-12 flex justify-center">
            <img src="https://futurepreneursummit.com/build/assets/Logo-FEST-LIGHT-BTlW9aSe.png" alt="Logo"
                class="relative z-10 scale-95 lg:scale-150x transition-transform duration-300 hover:scale-175" />
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
                    <label class="text-start block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" value="{{ $googleData['name'] }}" readonly
                        class="w-full border  border-gray-300 rounded-lg p-3 bg-gray-50 text-zinc-400 text-sm focus:outline-none cursor-not-allowed" readonly>
                </div>

                <div class="mb-5">
                    <label class="text-start block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $googleData['email'] }}" readonly
                        class="w-full border border-gray-300 rounded-lg p-3 bg-gray-50 text-zinc-400 text-sm focus:outline-none cursor-not-allowed" readonly>
                </div>

                <div class="mb-5">
                    <label class="text-start block text-sm font-medium text-gray-700 mb-2">
                        Campus <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="campus" value="{{ old('campus') }}"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                        required placeholder="Enter your campus name">
                    @error('campus')
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

                <div class="mb-6">
                    <label class="text-start block text-sm font-medium text-gray-700 mb-2">
                        City <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="no_telp" value="{{ old('no_telp') }}"
                        class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow"
                        required placeholder="Enter your city">
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