<aside class="flex flex-col min-h-screen w-64 border-r-2 border-zinc-800 bg-background text-slate-100">
    <!-- Header -->
    <div class="flex items-center gap-3 p-4 border-b border-zinc-800">
        <div
            class="flex items-center justify-center h-10 w-10 rounded-lg bg-gradient-to-br from-teal-700 via-teal-600 to-teal-500 shadow-md">
            <span class="font-extrabold text-sm tracking-tight">OC</span>
        </div>
        <div>
            <div class="text-sm font-semibold">E-Ticket FES</div>
            <div class="text-xs text-slate-400">Admin Panel</div>
        </div>
    </div>

    <!-- Content -->
    <nav class="flex-1 overflow-y-auto p-3 space-y-6">

        <!-- Manage Section -->
        <div>
            <ul class="space-y-1">
                <li>
                    <a href="/dashboard/overview"
                        class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-primary @if (request()->routeIs('dashboard')) bg-teal-600/20 ring-1 ring-teal-500/20 @endif">
                        <span class="flex items-center justify-center h-8 w-8 rounded-md">
                            <x-lucide-home class="h-5 w-5" />
                        </span>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </li>

            </ul>
        </div>

        <h6 class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">
            Manage
        </h6>
        <div>
            <ul class="space-y-1">
                <li>
                    <a href="/events/overview"
                        class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-primary @if (request()->routeIs('dashboard')) bg-teal-600/20 ring-1 ring-teal-500/20 @endif">
                        <span class="flex items-center justify-center h-8 w-8 rounded-md">
                            <x-lucide-calendar-days class="h-5 w-5" />
                        </span>
                        <span class="text-sm">Event</span>
                    </a>
                </li>
                <li>
                    <a href=""
                        class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-primary @if (request()->routeIs('users.*')) bg-teal-600/20 ring-1 ring-teal-500/20 @endif">
                        <span class="flex items-center justify-center h-8 w-8 rounded-md">
                            <x-lucide-users class="h-5 w-5" />
                        </span>
                        <span class="text-sm">Participants</span>
                    </a>
                </li>
                <li>
                    <a href=""
                        class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-primary @if (request()->routeIs('users.*')) bg-teal-600/20 ring-1 ring-teal-500/20 @endif">
                        <span class="flex items-center justify-center h-8 w-8 rounded-md">
                            <x-lucide-puzzle class="h-5 w-5" />
                        </span>
                        <span class="text-sm">Tokens</span>
                    </a>
                </li>
                <li>
                    <a href=""
                        class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-primary @if (request()->routeIs('users.*')) bg-teal-600/20 ring-1 ring-teal-500/20 @endif">
                        <span class="flex items-center justify-center h-8 w-8 rounded-md">
                            <x-lucide-users class="h-5 w-5" />
                        </span>
                        <span class="text-sm">Users</span>
                    </a>
                </li>
                <li>
                    <a href=""
                        class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-primary @if (request()->routeIs('users.*')) bg-teal-600/20 ring-1 ring-teal-500/20 @endif">
                        <span class="flex items-center justify-center h-8 w-8 rounded-md">
                            <x-lucide-bell class="h-5 w-5" />
                        </span>
                        <span class="text-sm">Notification</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Misc Section -->
        <div>
            <h6 class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">
                Misc
            </h6>
            <ul class="space-y-1">
                <li>
                    <a href=""
                        class="flex items-center gap-3 py-2 px-3 rounded-md hover:bg-primary @if (request()->routeIs('settings')) bg-teal-600/20 ring-1 ring-teal-500/20 @endif">
                        <span class="flex items-center justify-center h-8 w-8 rounded-md">
                            <x-lucide-settings class="h-5 w-5" />
                        </span>
                        <span class="text-sm">Settings</span>
                    </a>
                </li>
            </ul>
        </div>

    </nav>


    <!-- Footer -->
    <div class="p-3 border-t border-slate-800">
        <div>
            <div class="text-xs text-slate-400">Signed in as</div>
            <div class="font-medium">Alif Adiawan</div>
        </div>
    </div>
</aside>
