@extends('Layouts.Main')
@section('content')

    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card 1: Event Form -->
            <div class="card-1 bg-primary p-6 rounded-2xl shadow-lg border border-zinc-800">
                <h2 class="text-lg font-semibold mb-4 text-white">Create New Event</h2>

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-zinc-300 mb-1">Event Name</label>
                        <input type="text" name="name" id="name"
                            class="w-full px-3 py-2 rounded-lg bg-[#121212] border border-zinc-700 focus:ring-2 focus:ring-accent focus:border-accent focus:outline-none text-white placeholder-zinc-500"
                            placeholder="Enter event name" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-zinc-300 mb-1">Start Date</label>
                            <input type="date" name="start_date" id="start_date"
                                class="w-full px-3 py-2 rounded-lg bg-[#121212] border border-zinc-700 focus:ring-2 focus:ring-accent focus:border-accent focus:outline-none text-white">
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-medium text-zinc-300 mb-1">End Date</label>
                            <input type="date" name="end_date" id="end_date"
                                class="w-full px-3 py-2 rounded-lg bg-[#121212] border border-zinc-700 focus:ring-2 focus:ring-accent focus:border-accent focus:outline-none text-white">
                        </div>
                    </div>

                    <div>
                        <label for="string" class="block text-sm font-medium text-zinc-300 mb-1">Custom String</label>
                        <input type="text" name="string" id="string"
                            class="w-full px-3 py-2 rounded-lg bg-[#121212] border border-zinc-700 focus:ring-2 focus:ring-accent focus:border-accent focus:outline-none text-white placeholder-zinc-500"
                            placeholder="Optional custom string">
                    </div>
                </div>
            </div>

            <!-- Card 2: E-Ticket Upload -->
            <div class="card-2 bg-primary p-6 rounded-2xl shadow-lg border border-zinc-800">
                <h2 class="text-lg font-semibold mb-2 text-white">Custom E-Ticket Design</h2>
                <span class="text-red-500 text-xs mb-1">*</span>
                <span class="text-sm text-zinc-500 mb-4 block">Minimum size: 224x778 px</span>

                <input type="file" id="ticketInput" name="custom-ticket-pict" accept="image/*"
                    class="w-full px-3 py-2 rounded-lg bg-[#121212] border border-zinc-700 focus:ring-2 focus:ring-accent focus:border-accent focus:outline-none text-white cursor-pointer">

                <!-- Preview -->
                <div class="mt-4">
                    <img id="ticketPreview" class="hidden w-full rounded-lg border border-zinc-700" alt="Preview">
                </div>
            </div>
        </div>

        <!-- Submit button below grid so it spans across -->
        <div class="mt-6">
            <button type="submit"
                class="w-full bg-accent hover:bg-[#b695c5] text-black font-semibold py-3 px-4 rounded-lg transition">
                Save Event
            </button>
        </div>
    </form>

    <script>
        document.getElementById('ticketInput').addEventListener('change', function (e) {
            const file = e.target.files[0];
            const preview = document.getElementById('ticketPreview');

            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        });
    </script>




@endsection