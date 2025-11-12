<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tiket Event</title>

  @vite(['resources/css/app.css'])

</head>

<body class="min-h-screen grid place-items-center p-8 font-sans text-dark bg-cover bg-center bg-no-repeat"
  style="background-image: url('{{ asset('bg_hiring.png') }}')">


  <div id="ticket-card" class="w-full max-w-[450px] mx-auto text-center">
    <div class="relative bg-white shadow-lg rounded-[2rem] p-8 border border-zinc-200 overflow-hidden">

      <!-- Perforated edge effect (left + right) -->
      <div class="absolute top-1/2 -left-3 w-6 h-6 bg-zinc-100 rounded-full border border-zinc-300"></div>
      <div class="absolute top-1/2 -right-3 w-6 h-6 bg-zinc-100 rounded-full border border-zinc-300"></div>

      <!-- Header -->
      <div class="ticket-header mb-4">
        <h1 class="text-2xl font-bold text-zinc-800 tracking-tight">E - Ticket</h1>
      </div>

      <!-- QR -->
      <div class="rounded-xl mx-auto my-6 max-w-[240px] border border-zinc-200 p-3 bg-zinc-50">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=ZLX2MHD4" alt="Kode QR"
          class="w-full block rounded-md">
      </div>

      <!-- Dotted Line -->
      <div class="w-full border-t border-dashed border-zinc-300 my-5"></div>

      <!-- Event Name -->
      <h1 class="font-bold text-xl text-zinc-800 mb-4">
        {{ $token_credentials->event->name }}
      </h1>

      <!-- Info Section -->
      <div class="pt-4 text-left flex flex-col gap-5">

        <!-- Token -->
        <div class="flex flex-col flex-1">
          <span class="text-xs text-zinc-400 uppercase tracking-wider font-semibold mb-1">Token</span>
          <span class="text-lg font-bold text-zinc-800">{{ $token_credentials->token }}</span>
        </div>

        <!-- Status -->
        <div class="flex flex-col">
          <span class="text-xs text-zinc-400 uppercase tracking-wider font-semibold mb-1">Status</span>
          <div
            class="w-fit py-1.5 px-4 bg-[#E8F5E9] text-[#2E7D32] rounded-full text-xs font-semibold uppercase tracking-wide mt-1">
            {{ $token_credentials->status }}
          </div>
        </div>

        <!-- Created -->
        <div class="flex flex-col flex-1">
          <span class="text-xs text-zinc-400 uppercase tracking-wider font-semibold mb-1">Dibuat</span>
          <span class="text-lg font-bold text-zinc-800">{{ $token_credentials->created_at }}</span>
        </div>

        <div class="mt-8 flex items-center justify-center gap-3">
          <button id="saveTicket"
            class="px-5 py-2.5 bg-[#7e22ce] hover:bg-[#6b21a8] text-white font-semibold rounded-full text-sm transition">
            Save to Device
          </button>
          <button id="shareTicket"
            class="px-5 py-2.5 bg-[#7e22ce] hover:bg-[#6b21a8] text-white font-semibold rounded-full text-sm transition">
            Share
          </button>
        </div>


      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/html2canvas-pro@1.5.13/dist/html2canvas-pro.min.js"></script>
  <script>
    const saveBtn = document.getElementById('saveTicket');
    const shareBtn = document.getElementById('shareTicket');
    const ticket = document.getElementById('ticket-card');

    // 📸 Save as Image
    saveBtn.addEventListener('click', async () => {
      const canvas = await html2canvas(ticket, {
        scale: 2,
        useCORS: true,
        allowTaint: true,
        backgroundColor: '#ffffff',
        logging: false
      });
      const link = document.createElement('a');
      link.download = 'e-ticket.png';
      link.href = canvas.toDataURL('image/png');
      link.click();
    });

    // 📤 Share Ticket (if supported)
    shareBtn.addEventListener('click', async () => {
      try {
        const canvas = await html2canvas(ticket, { scale: 2 });
        canvas.toBlob(async (blob) => {
          const file = new File([blob], 'e-ticket.png', { type: 'image/png' });
          if (navigator.share && navigator.canShare({ files: [file] })) {
            await navigator.share({
              title: 'E-Ticket Saya',
              text: 'Berikut e-ticket saya 🎟️',
              files: [file]
            });
          } else {
            alert('Fitur share tidak didukung di perangkat ini.');
          }
        });
      } catch (err) {
        console.error('Gagal membagikan tiket:', err);
      }
    });
  </script>

</body>

</html>