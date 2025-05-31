<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservasi Dibatalkan - Bukti Refund</title>
    <style>
        /* ---------- Contoh style sederhana ---------- */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 24px auto;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
        }

        .header {
            background-color: #ef4444;
            /* merah */
            color: #fff;
            padding: 16px 24px;
            text-align: center;
        }

        .body {
            padding: 24px;
            line-height: 1.6;
        }

        .footer {
            background-color: #f3f4f6;
            color: #6b7280;
            padding: 16px 24px;
            font-size: 12px;
            text-align: center;
        }

        .btn-refund {
            display: inline-block;
            padding: 10px 20px;
            background-color: #ef4444;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 16px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Reservasi Dibatalkan</h2>
        </div>

        <!-- Body -->
        <div class="body">
            <p>Halo <strong>{{ $reservasi->guest->full_name }}</strong>,</p>

            <p>
                Ini adalah bukti bahwa reservasi Anda dengan ID <strong>#{{ $reservasi->id_reservation }}</strong>
                untuk villa <strong>{{ $reservasi->villa->name }}</strong> telah <strong>dibatalkan</strong>.
            </p>

            <p>
                <strong>Detail Reservasi:</strong><br>
                • Check-in : {{ \Carbon\Carbon::parse($reservasi->start_date)->format('d M Y') }}<br>
                • Check-out: {{ \Carbon\Carbon::parse($reservasi->end_date)->format('d M Y') }}<br>
                • Total pembayaran: Rp{{ number_format($reservasi->total_amount, 0, ',', '.') }}
            </p>

            <p>
                Silakan <strong>tunjukkan email ini kepada petugas</strong> di loket refund sebagai bukti.
                Anda dapat melakukan proses refund di tempat dengan membawa identitas yang sama seperti pada saat
                pemesanan.
            </p>

            <p>
                Jika ada kendala atau pertanyaan lebih lanjut, silakan hubungi customer service kami.
            </p>

            <p>Terima kasih,</p>
            <p><em>{{ config('app.name') }}</em></p>

            <p style="margin-top: 32px; font-size: 12px; color: #6b7280;">
                Jika Anda tidak merasa membuat pemesanan ini, abaikan email ini atau hubungi kami.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>

</html>
