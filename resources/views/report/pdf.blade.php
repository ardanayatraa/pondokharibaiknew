<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan {{ ucfirst($type) }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2,
        p {
            margin: 0;
            padding: 0;
        }

        .header {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan {{ ucfirst($type) }}</h2>
        <p>Periode: {{ $start ?? '-' }} s/d {{ $end ?? '-' }}</p>
    </div>

    @php
        use Carbon\Carbon;
        $chunks = $data->chunk(20);
    @endphp

    @foreach ($chunks as $chunk)
        @php $subtotal = 0; @endphp
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Detail</th>
                    @if ($type !== 'pembayaran')
                        <th>Start</th>
                        <th>End</th>
                        <th>Malam</th>
                    @endif
                    <th style="text-align:right;">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($chunk as $i => $item)
                    @php
                        $startDate = $type === 'pembayaran' ? null : Carbon::parse($item->start_date);
                        $endDate = $type === 'pembayaran' ? null : Carbon::parse($item->end_date);
                        $malam = $startDate && $endDate ? $endDate->diffInDays($startDate) : 0;
                        $amount = $type === 'pembayaran' ? $item->amount : $item->total_amount ?? 0;
                        $subtotal += $amount;
                    @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $type === 'pembayaran' ? $item->payment_date : $item->start_date ?? '-' }}</td>
                        <td>{{ $item->guest->full_name ?? '-' }}</td>
                        <td>{{ $type === 'pembayaran' ? 'Pembayaran Reservasi' : $item->villa->name ?? '-' }}</td>

                        @if ($type !== 'pembayaran')
                            <td>{{ $startDate?->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $endDate?->format('d-m-Y') ?? '-' }}</td>
                            <td>{{ $malam }} malam</td>
                        @endif

                        <td style="text-align:right;">{{ number_format($amount, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    @php $colspan = $type === 'pembayaran' ? 4 : 7; @endphp
                    <td colspan="{{ $colspan }}" style="text-align:right;">Subtotal</td>
                    <td style="text-align:right;">{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>

</html>
