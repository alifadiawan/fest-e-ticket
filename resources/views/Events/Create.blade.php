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
                    </div
                    >
                    <div>
                        <label for="location" class="block text-sm font-medium text-zinc-300 mb-1">Location</label>
                        <input type="text" name="location" id="location"
                            class="w-full px-3 py-2 rounded-lg bg-[#121212] border border-zinc-700 focus:ring-2 focus:ring-accent focus:border-accent focus:outline-none text-white placeholder-zinc-500"
                            placeholder="Enter location" required>
                    </div>

                    <label for="location" class="block text-sm font-medium text-zinc-300 mb-3">Status</label>
                   <div class="flex gap-2 flex-wrap ">
                        @foreach (\App\Models\EventModel::statuses() as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="status" value="{{ $value }}"
                                    class="hidden peer"
                                    {{ (old('status', $event->status ?? \App\Models\EventModel::DRAFT)) === $value ? 'checked' : '' }}>
                                <span
                                    class="px-4 py-2 rounded-full border border-zinc-700 text-sm
                                    peer-checked:bg-accent peer-checked:text-white
                                    bg-[#121212] text-zinc-300 hover:border-accent transition">
                                    {{ $label }}
                                </span>
                            </label>
                        @endforeach
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

                   
                </div>
            </div>

            <!-- Card 2: E-Ticket Upload -->
            <div class="card-2 bg-primary p-6 rounded-2xl shadow-lg border border-zinc-800">
                <h2 class="text-lg font-semibold mb-2 text-white">Custom E-Ticket Design</h2>
                <span class="text-red-500 text-xs mb-1">*</span>
                <span class="text-sm text-zinc-500 mb-4 block">Minimum size: 224x778 px</span>

                <input type="file" id="ticketInput" name="custom_ticket_pict" accept="image/*"
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