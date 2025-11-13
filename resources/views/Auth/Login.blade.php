<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>

    <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2 bg-black">

        <!-- Left: Full-height Image -->
        <div class="hidden lg:flex items-center justify-center">
            <img src="{{ asset('bg.png') }}" alt="Background" class="h-full w-full object-cover  shadow-lg">
        </div>

        <!-- Right: Login Form -->
        <div class="flex items-center justify-center px-6 py-12">
            <div
                class="backdrop-blur-lg rounded-2xl shadow-2xl p-10 w-full max-w-lg transition hover:shadow-violet-500/10">

                <div class="text-start mb-12">
                    <h1 class="text-5xl font-extrabold text-white tracking-tight">Event Management</h1>
                    <p class="text-gray-400 text-sm mt-2">Welcome back! Please sign in to continue.</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-7">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <input type="email" id="email" name="email" placeholder="enter your email"
                            class="block w-full px-4 py-2.5 bg-[#2A2A2A] border border-[#333333] text-white rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent outline-none transition">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                        <input type="password" id="password" name="password" placeholder="••••••••"
                            class="block w-full px-4 py-2.5 bg-[#2A2A2A] border border-[#333333] text-white rounded-lg focus:ring-2 focus:ring-violet-500 focus:border-transparent outline-none transition">
                    </div>

                    <div class="mt-12">
                        <button type="submit"
                            class="w-full bg-violet-500 hover:bg-violet-600 text-white py-2.5 rounded-lg font-semibold transition-transform hover:scale-[1.03]">
                            Sign In
                        </button>
                    </div>

                
                </form>
            </div>
        </div>

    </div>

</body>

</html>