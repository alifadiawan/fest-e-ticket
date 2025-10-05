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
        class="relative w-96 pb-6 px-6 pt-0 bg-white rounded-xl shadow-lg z-10 text-center transition-all duration-700 ease-in-out opacity-0 scale-95">

        <div class="relative mb-12 flex justify-center">
            <img src="https://futurepreneursummit.com/build/assets/Logo-FEST-LIGHT-BTlW9aSe.png" alt="Logo"
                class="relative z-10 scale-95 lg:scale-150x      transition-transform duration-300 hover:scale-175" />
        </div>

        @if(isset($error))
            <div class="bg-red-200 border-red-500 text-red-500 p-2 rounded mb-5">
                {{ $error }}
            </div>
        @else

        @endif


        @if(isset($error))
            
        @else
            <a href="{{ route('google.redirect', ['token' => $token])}}"
                class="flex justify-center items-center gap-2 w-full bg-white border border-gray-300 rounded-lg px-6 py-3 text-sm font-medium text-gray-800 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="-0.5 0 48 48">
                    <g fill="none" fill-rule="evenodd">
                        <path
                            d="M9.827 24c0-1.524.253-2.985.705-4.356L2.623 13.604C1.082 16.734.214 20.26.214 24c0 3.737.868 7.262 2.407 10.389l7.905-6.051A14.127 14.127 0 0 1 9.827 24"
                            fill="#FBBC05" />
                        <path
                            d="M23.714 10.133c3.311 0 6.302 1.174 8.652 3.094l6.836-6.827C35.036 2.773 29.695.533 23.714.533c-9.287 0-17.568 5.31-21.09 13.071l7.908 6.04c1.822-5.532 7.016-9.511 13.182-9.511"
                            fill="#EB4335" />
                        <path
                            d="M23.714 37.867c-6.165 0-11.36-3.979-13.182-9.511L2.623 34.395c3.822 7.761 12.803 13.072 21.091 13.072 5.732 0 11.204-2.035 15.312-5.849l-7.507-5.804c-2.118 1.334-4.785 2.053-7.805 2.053"
                            fill="#34A853" />
                        <path
                            d="M46.145 24c0-1.387-.213-2.88-.534-4.267H23.714V28.8h12.604c-.63 3.091-2.345 5.468-4.8 7.014l7.507 5.804C43.34 37.614 46.145 31.649 46.145 24"
                            fill="#4285F4" />
                    </g>
                </svg>
                <span>Register With Google</span>
            </a>
        @endif

        <form id="manualForm" action="" method="POST" class="space-y-4 hidden">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 text-left">Name</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 text-left">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 text-left">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600 transition">
                Register
            </button>
        </form>
    </div>

    <script>
        // This waits for the entire page (including images) to load
        window.addEventListener('load', () => {
            const card = document.getElementById('registrationCard');

            // Remove the initial state classes to trigger the CSS transition
            card.classList.remove('opacity-0', 'scale-95');
        });
    </script>
</body>

</html>