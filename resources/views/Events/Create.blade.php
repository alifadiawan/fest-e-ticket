@extends('Layouts.Main')
@section('content')
    <form action="{{ route('events.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium mb-1">Event Name</label>
            <input type="text" name="name" id="name"
                class="w-full px-3 py-2 rounded-lg bg-gray-700 border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                required>
        </div>

        <div>
            <label for="start_date" class="block text-sm font-medium mb-1">Start Date</label>
            <input type="date" name="start_date" id="start_date"
                class="w-full px-3 py-2 rounded-lg bg-gray-700 border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label for="end_date" class="block text-sm font-medium mb-1">End Date</label>
            <input type="date" name="end_date" id="end_date"
                class="w-full px-3 py-2 rounded-lg bg-gray-700 border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <div>
            <label for="string" class="block text-sm font-medium mb-1">Custom String</label>
            <input type="text" name="string" id="string"
                class="w-full px-3 py-2 rounded-lg bg-gray-700 border border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
            Save Event
        </button>
    </form>
@endsection
