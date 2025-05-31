<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Instruksi Refund & Reschedule - Reservasi #{{ $reservasi->id_reservation }}</title>
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
            background-color: #1f2937;
            /* abu tua */
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
            background-color: #dc2626;
            /* merah gelap */
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            margin-top: 16px;
        }

        .btn-book {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2563eb;
            /* biru */
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
            <h2>Reservasi Dijadwal Ulang</h2>
        </div>

        <!-- Body -->
        <div class="body">
            <p>Halo <strong>{{ $reservasi->guest->full_name }}</strong>,</p>

            <p>
                Reservasi Anda dengan ID <strong>#{{ $reservasi->id_reservation }}</strong>
                untuk villa <strong>{{ $reservasi->villa->name }}</strong> pada:
            </p>
            <ul>
                <li>Check-in : {{ \Carbon\Carbon::parse($reservasi->start_date)->format('d M Y') }}</li>
                <li>Check-out: {{ \Carbon\Carbon::parse($reservasi->end_date)->format('d M Y') }}</li>
                <li>Total pembayaran: Rp{{ number_format($reservasi->total_amount, 0, ',', '.') }}</li>
            </ul>

            <p>
                Karena beberapa kendala, reservasi di atas <strong>harus dijadwal ulang</strong>.
                Berikut langkah-langkah yang harus Anda lakukan:
            </p>
            <ol>
                <li>
                    <strong>Refund</strong>:
                    Tunjukkan email ini kepada petugas refund di loket.
                    Beserta identitas yang sesuai (nama & email) seperti pada saat pemesanan.
                </li>
                <li>
                    <strong>Reschedule / Pemesanan Ulang</strong>:
                    Setelah proses refund selesai, silakan lakukan pemesanan baru.
                    Proses pemesanan ulang sama persis seperti biasanya:
                    <ul>
                        <li>Pilih tanggal baru</li>
                        <li>Ketersediaan villa akan diperiksa otomatis</li>
                        <li>Bayar dan terima konfirmasi</li>
                    </ul>
                </li>
            </ol>

            <p>
                Jika Anda memerlukan bantuan lebih lanjut, silakan hubungi customer service kami.
            </p>

            <p>Terima kasih,</p>
            <p><em>{{ config('app.name') }}</em></p>

            <p style="margin-top: 32px; font-size: 12px; color: #6b7280;">
                Jika Anda tidak merasa melakukan pemesanan ini, abaikan email ini atau hubungi kami.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>

</html>
