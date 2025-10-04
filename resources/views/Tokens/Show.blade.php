@extends('Layouts.Main')
@section('page-title', 'Tokens for : ' . $tokendetail[0]->event->name)
@section('back', true)
@section('content')

    <div class="overflow-x-auto mb-5">
        <table class="table-auto w-full border-collapse border border-zinc-700 text-sm">
            <thead class="bg-primary">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Token</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Used By</th>

                    <th class="px-4 py-2">Used At</th>
                    <th class="px-4 py-2">Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tokendetail as $item)
                    <tr class="text-center hover:bg-zinc-900">
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 font-mono">{{ $item->token }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-2 py-1 rounded 
                                        {{ $item->status === 'unused' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">
                            <a href="{{ route('user.show', $item->user->id ?? '-') }}"
                                class="hover:underline">{{ $item->user->name ?? '-' }}</a>
                        </td>
                        <td class="px-4 py-2">{{ $item->used_at ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $tokendetail->links() }}


@endsection