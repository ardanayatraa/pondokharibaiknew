<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #{{ $reservasi->id_reservation }} - Pondok Hari Baik</title>
    <style>
        /* Reset dan base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background-color: #fdfdfd;
        }

        /* Margin kertas saat cetak (opsional) */
        @page {
            size: auto;
            margin: 20mm;
        }

        /* Helper: beri margin-top saja */
        .new-page {
            margin-top: 40px;
        }

        /* Hindari terpotong di tengah tabel atau section */
        .section,
        .pricing,
        .totals-container {
            page-break-inside: avoid;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #eaeaea;
            border-radius: 8px;
        }

        /* Header sebagai table */
        table.header-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
        }

        table.header-table td {
            vertical-align: top;
            padding: 0 10px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
        }

        .company-info {
            font-size: 13px;
            color: #7f8c8d;
            margin-top: 4px;
            line-height: 1.4;
        }

        .invoice-details {
            text-align: right;
            font-size: 13px;
        }

        .invoice-id {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .invoice-date,
        .invoice-status {
            color: #7f8c8d;
            margin-bottom: 2px;
        }

        /* Section title */
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 10px;
            padding-bottom: 4px;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-label {
            font-weight: 600;
            color: #7f8c8d;
            width: 80px;
            display: inline-block;
        }

        .info-value {
            color: #2c3e50;
        }

        /* Layout side-by-side */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .info-table td {
            vertical-align: top;
            padding: 0 20px;
        }

        /* Pricing per malam */
        table.pricing {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table.pricing thead {
            background-color: #2c3e50;
            color: #fff;
        }

        table.pricing th,
        table.pricing td {
            padding: 10px 12px;
            text-align: left;
            border-bottom: 1px solid #eaeaea;
        }

        table.pricing tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        /* Totals */
        .totals-container {
            display: flex;
            justify-content: flex-end;
        }

        .totals {
            width: 300px;
        }

        .totals table {
            width: 100%;
            border-collapse: collapse;
        }

        .totals th,
        .totals td {
            border: none;
            padding: 8px 12px;
        }

        .totals th {
            font-weight: 600;
            color: #7f8c8d;
        }

        .grand-total {
            font-weight: bold;
            background-color: #2c3e50;
            color: #fff;
        }

        /* Footer */
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #f0f0f0;
            text-align: center;
            color: #7f8c8d;
            font-size: 13px;
        }

        .thank-you {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        @media print {
            .container {
                margin: 0;
                border: none;
                border-radius: 0;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- HEADER PAKAI TABLE -->
        <table class="header-table">
            <tr>
                <td style="width:50%">
                    <div class="logo">Pondok Hari Baik</div>
                    <div class="company-info">
                        Jalan Raya Denpasar – Gilimanuk,<br>
                        Tabanan, Bali<br>
                        info@pondokharibaik.com
                    </div>

                </td>
                <td style="width:50%">
                    <div class="invoice-details">
                        <div class="invoice-id">INVOICE #{{ $reservasi->id_reservation }}</div>
                        <div class="invoice-date">
                            Tanggal: {{ \Carbon\Carbon::parse($reservasi->created_at)->format('d M Y') }}
                        </div>
                        <div class="invoice-status">
                            Status: {{ ucfirst($pembayaran->status) }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- INFO TAMU & DETAIL RESERVASI SIDE-BY-SIDE -->
        <table class="info-table">
            <tr>
                <td>
                    <div class="section">
                        <h3 class="section-title">Informasi Tamu</h3>
                        <p><span class="info-label">Nama:</span>
                            <span class="info-value">{{ $reservasi->guest->full_name }}</span>
                        </p>
                        <p><span class="info-label">Email:</span>
                            <span class="info-value">{{ $reservasi->guest->email }}</span>
                        </p>
                        <p><span class="info-label">No. Telp:</span>
                            <span class="info-value">{{ $reservasi->guest->phone_number }}</span>
                        </p>
                    </div>
                </td>
                <td>
                    <div class="section">
                        <h3 class="section-title">Detail Reservasi</h3>
                        <p><span class="info-label">Villa:</span>
                            <span class="info-value">{{ $reservasi->villa->name }}</span>
                        </p>
                        <p><span class="info-label">Check-in:</span>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($reservasi->start_date)->format('d M Y') }}
                            </span>
                        </p>
                        <p><span class="info-label">Check-out:</span>
                            <span class="info-value">
                                {{ \Carbon\Carbon::parse($reservasi->end_date)->format('d M Y') }}
                            </span>
                        </p>
                        <p><span class="info-label">Durasi:</span>
                            <span class="info-value">{{ $nights }} malam</span>
                        </p>
                    </div>
                </td>
            </tr>
        </table>


        <!-- BAGIAN DENGAN MARGIN-TOP -->
        <div class="new-page">
            <div class="section">
                <h3 class="section-title">Rincian Harga per Malam</h3>
                <table class="pricing">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th class="text-right">Harga/Malam (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $nights; $i++)
                            @php
                                $date = \Carbon\Carbon::parse($reservasi->start_date)->addDays($i)->format('d M Y');
                                $price = $reservasi->villa->priceForDate($date);
                            @endphp
                            <tr>
                                <td>{{ $date }}</td>
                                <td class="text-right">{{ number_format($price, 0, ',', '.') }}</td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TOTALS -->
        <div class="totals-container">
            <div class="totals">
                <table>
                    <tr>
                        <th>Total ({{ $nights }} malam)</th>
                        <td class="text-right">
                            Rp {{ number_format($reservasi->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Dibayar</th>
                        <td class="text-right">
                            Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="grand-total">
                        <th>Sisa</th>
                        <td class="text-right">
                            Rp {{ number_format($reservasi->total_amount - $pembayaran->amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <div class="thank-you">Terima Kasih Atas Kunjungan Anda!</div>
            <p>Jika ada pertanyaan mengenai invoice ini, silakan hubungi kami di info@pondokharibaik.com</p>
            <p>&copy; {{ date('Y') }} Pondok Hari Baik. Semua hak dilindungi.</p>
        </div>

    </div>
</body>

</html>
