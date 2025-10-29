@extends('Layouts.Main')
@section('page-title', "Create Certificate")
@section('content')


    @if ($errors->any())
        <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('certificate.store', $event[0]->id) }}" method="POST" enctype="multipart/form-data"
        class="space-y-5">
        @csrf

        <input type="hidden" name="event_id" value="{{ $event[0]->id }}">

        <!-- Certificate Name -->
        <div>
            <label for="certificate_name" class="block text-sm font-medium text-gray-300 mb-1">
                Certificate Name
            </label>
            <input type="text" name="certificate_name" id="certificate_name"
                class="w-full rounded-lg bg-[var(--color-primary-light)] border border-gray-700 text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent p-2.5 @error('certificate_name') border-red-500 @enderror"
                placeholder="Enter certificate name" value="{{ old('certificate_name') }}" required>
            @error('certificate_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Upload -->
        <div>
            <label for="file" class="block text-sm font-medium text-gray-300 mb-1">
                Upload File (optional)
            </label>
            <input type="file" name="file" id="file" accept=".pdf,.jpg,.png"
                class="w-full rounded-lg bg-[var(--color-primary-light)] border border-gray-700 text-gray-100 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[var(--color-accent)] file:text-[var(--color-primary)] hover:file:bg-opacity-90 focus:ring-2 focus:ring-[var(--color-accent)] focus:border-transparent p-2.5 @error('file') border-red-500 @enderror">
            @error('file')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
            <p class="text-gray-500 text-sm mt-1">Allowed: PDF, JPG, PNG (max 2MB)</p>
        </div>

        <!-- Submit Button -->
        <div class="text-right">
            <button type="submit"
                class="px-5 py-2.5 bg-[var(--color-accent)] text-[var(--color-primary)] font-semibold rounded-lg shadow-md hover:bg-opacity-90 transition duration-200">
                Create Certificate
            </button>
        </div>
    </form>


@endsection