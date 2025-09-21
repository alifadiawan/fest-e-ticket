<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-background flex">

    {{-- Sidebar --}}
    @include('Layouts.Sidebar')

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col min-h-screen">
        {{-- Topbar --}}
        {{-- @include('Layouts.Topbar') --}}

        {{-- Content --}}

        <div class="flex-1 p-6 text-white">
            @hasSection('back')
                <div class="flex flex-row justify-start items-center gap-5 mb-6">
                    <a href="{{ url()->previous() }}"
                        class="flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-zinc-900 transition">
                        <x-lucide-arrow-left class="w-5 h-5" />
                    </a>
                    <h1 class="font-bold text-3xl">@yield('page-title')</h1>
                </div>
            @else
                <h1 class="font-bold text-3xl mb-6">@yield('page-title')</h1>
            @endif

            @yield('content')
        </div>
    </div>

</body>

</html>
