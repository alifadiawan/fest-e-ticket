<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
</style>

<body>
    <div class="container w-full">

        <div class="min-h-screen flex flex-col items-center justify-center bg-background">

            <!-- Left: Logo / Title -->
            <div class="bg-secondary rounded-full px-8 py-3 shadow-lg z-50 mb-8">
                <div class="flex items-center justify-center min-w-[28rem] text-white">
                    <div class="font-bold text-lg">
                        LOGIN
                    </div>
                </div>
            </div>
            
            <!-- Login Card -->
            <div class="bg-secondary shadow-lg rounded-4xl p-8 w-full max-w-lg">

                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input type="email" id="email" name="email" placeholder="you@example.com"
                            class="mt-1 block w-full px-4 py-2 bg-[#2A2A2A] border border-[#333333] text-white rounded-full focus:ring-violet-500 focus:border-violet-500 outline-none">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                        <input type="password" id="password" name="password" placeholder="••••••••"
                            class="mt-1 block w-full px-4 py-2 bg-[#2A2A2A] border border-[#333333] text-white rounded-full focus:ring-violet-500 focus:border-violet-500 outline-none">
                    </div>

                    <button type="submit"
                        class="w-full bg-violet-500 text-background py-2 px-4 mt-5 rounded-full font-semibold hover:scale-103 transition">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
