<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Perihal: Konfirmasi Reschedule Reservasi #{{ $reservasi->id_reservation }}</title>
    <style>
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
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <h2>Perihal: Konfirmasi Reschedule Reservasi #{{ $reservasi->id_reservation }}</h2>
        </div>

        <!-- Body -->
        <div class="body">
            <p>Halo <strong>{{ $reservasi->guest->full_name }}</strong>,</p>

            <p>
                Kami mengkonfirmasi bahwa reservasi Anda dengan nomor
                <strong>#{{ $reservasi->id_reservation }}</strong>,
                yang sebelumnya dijadwalkan untuk:
            </p>

            <p>
                • Villa: <strong>{{ $reservasi->villa->name }}</strong><br>
                • Check-in: {{ \Carbon\Carbon::parse($reservasi->start_date)->format('d M Y') }}<br>
                • Check-out: {{ \Carbon\Carbon::parse($reservasi->end_date)->format('d M Y') }}<br>
                • Total Pembayaran: Rp{{ number_format($reservasi->total_amount, 0, ',', '.') }}
            </p>

            <p>
                Saat ini reservasi Anda <strong>akan dijadwalkan ulang (reschedule)</strong> karena adanya kendala.
            </p>

            <p>
                Sesuai dengan ketentuan pembatalan, proses pengembalian dana akan dilakukan terlebih dahulu. Setelah
                proses refund selesai, Anda dapat melakukan pemesanan ulang (booking ulang) sesuai tanggal baru yang
                Anda inginkan.
            </p>

            <p>
                <strong>Langkah-langkah yang perlu dilakukan:</strong>
            </p>

            <ol>
                <li>
                    <strong>Proses Refund:</strong>
                    Silakan hubungi WhatsApp <strong>+62 812-3456-7890</strong> untuk pengajuan refund.
                    Mohon sertakan pesan konfirmasi ini serta identitas sesuai data pemesanan (nama & email).
                </li>
                <li>
                    <strong>Booking Ulang:</strong>
                    Setelah refund selesai, Anda dapat melakukan pemesanan ulang melalui website kami seperti biasa:
                    pilih tanggal baru → periksa ketersediaan villa → lakukan pembayaran → dapatkan konfirmasi baru.
                </li>
            </ol>

            <p>
                Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi customer service kami.
            </p>

            <p>Terima kasih atas pengertian Anda.</p>

            <p>Hormat kami,</p>
            <p><em>{{ config('app.name') }}</em></p>

            <p>
                Kontak: +62 812-3456-7890<br>
                Email: info@pondokharibaik.com
            </p>

            <p style="margin-top: 32px; font-size: 12px; color: #6b7280;">
                Jika Anda tidak merasa melakukan pemesanan ini, abaikan email ini atau segera hubungi kami.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Seluruh hak cipta dilindungi.
        </div>
    </div>
</body>

</html>
