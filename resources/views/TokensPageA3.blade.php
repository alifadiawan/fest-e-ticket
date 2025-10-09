<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>A3 QR Code Sheet</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
        }

        @page {
            size: A3 portrait;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            width: 20%;
            height: 49%;
            text-align: center;
            vertical-align: bottom;
            border: 1px solid #ccc;
            padding-bottom: 13px;
            @if (!empty($custom_image) && file_exists(public_path('storage/' . $custom_image)) && is_file(public_path('storage/' . $custom_image)))
                background: url('{{ public_path('storage/' . $custom_image) }}') no-repeat center center;
                background-size: cover;
            @else background-color: #333;
                /* or white */
            @endif
        }

        .qr-code {
            max-width: 90px;
            height: auto;
            padding-bottom: 25px;
        }

        .token {
            font-size: 7pt;
            padding-bottom: 35px;
            color: white;
            word-wrap: break-word;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    @foreach ($tokens->chunk(10) as $pageTokens)
        <table>
            <tr>
                @foreach ($pageTokens->slice(0, 5) as $t)
                        <td>
                            <img class="qr-code" src="data:image/svg+xml;base64,{!! base64_encode(
                        QrCode::format('svg')->size(150)->generate(url('/redeem/' . $t->token))
                    ) !!}" alt="QR Code">
                            <div class="token">{{ $t->token }}</div>
                        </td>
                @endforeach

                {{-- Fill empty cells if less than 5 --}}
                @for ($i = 0; $i < 5 - $pageTokens->slice(0, 5)->count(); $i++)
                    <td></td>
                @endfor
            </tr>

            <tr>
                @foreach ($pageTokens->slice(5, 5) as $t)
                        <td>
                            <img class="qr-code" src="data:image/svg+xml;base64,{!! base64_encode(
                        QrCode::format('svg')->size(150)->generate(url('/redeem/' . $t->token))
                    ) !!}" alt="QR Code">
                            <div class="token">{{ $t->token }}</div>
                        </td>
                @endforeach

                {{-- Fill empty cells if less than 5 --}}
                @for ($i = 0; $i < 5 - $pageTokens->slice(5, 5)->count(); $i++)
                    <td></td>
                @endfor
            </tr>
        </table>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>

</html>