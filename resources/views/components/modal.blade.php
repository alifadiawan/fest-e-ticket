<div>
    @props([
        'id' => 'defaultModal',
        'title' => 'Modal Title',
        'content' => '',
        'footer' => '',
    ])

    <div id="{{ $id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60">
        <div class="bg-primary text-gray-200 rounded-xl shadow-lg w-11/12 md:w-1/2 lg:w-1/3 p-6">

            {{-- Header --}}
            <div class="flex justify-between items-center pb-3">
                <h2 class="text-xl font-semibold">{{ $title }}</h2>
                <button onclick="closeModal('{{ $id }}')"
                    class="text-gray-400 hover:text-gray-200"><x-lucide-x class="h-6 w-6" /></button>
            </div>

            {{-- Body --}}
            <div class="mt-4">
                {{ $slot }}
            </div>

        </div>
    </div>

    {{-- JS to toggle modal --}}
    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
        }
    </script>

</div>
