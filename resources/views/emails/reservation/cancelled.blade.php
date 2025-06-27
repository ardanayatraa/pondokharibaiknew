<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Perihal: Konfirmasi Pembatalan Reservasi #{{ $reservasi->id_reservation }}</title>
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
            background-color: #ef4444;
            color: #fff;
            padding: 16px 24px;
            text-align: center;
        }

        .body {
            padding: 24px;
            line-height: 1.6;
        }

        .refund-info {
            background-color: #f0f9ff;
            border: 1px solid #0ea5e9;
            border-radius: 6px;
            padding: 16px;
            margin: 16px 0;
        }

        .refund-success {
            background-color: #f0fdf4;
            border: 1px solid #22c55e;
            border-radius: 6px;
            padding: 16px;
            margin: 16px 0;
        }

        .refund-failed {
            background-color: #fef2f2;
            border: 1px solid #ef4444;
            border-radius: 6px;
            padding: 16px;
            margin: 16px 0;
        }

        .footer {
            background-color: #f3f4f6;
            color: #6b7280;
            padding: 16px 24px;
            font-size: 12px;
            text-align: center;
        }

        .highlight {
            background-color: #fef3c7;
            padding: 2px 4px;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Perihal: Konfirmasi Pembatalan Reservasi #{{ $reservasi->id_reservation }}</h2>
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
                Telah <strong>dibatalkan</strong> pada
                {{ \Carbon\Carbon::parse($reservasi->cancelation_date)->format('d M Y H:i') }} WIB.
            </p>

            @php
                $totalPaid = $reservasi->pembayaran()->where('status', 'paid')->sum('amount');
                $refundAmount = $reservasi->pembayaran()->where('status', 'refunded')->sum('amount');
                $refundFailed = $reservasi->pembayaran()->where('status', 'refund_failed')->sum('amount');
                $latestPayment = $reservasi->pembayaran()->where('status', 'paid')->latest()->first();
                $isQrisPayment =
                    $latestPayment &&
                    (str_contains(strtolower($latestPayment->notifikasi ?? ''), 'qris') ||
                        str_contains(strtolower($latestPayment->notifikasi ?? ''), 'gopay') ||
                        str_contains(strtolower($latestPayment->notifikasi ?? ''), 'dana') ||
                        str_contains(strtolower($latestPayment->notifikasi ?? ''), 'ovo') ||
                        str_contains(strtolower($latestPayment->notifikasi ?? ''), 'shopeepay'));
            @endphp

            <!-- Refund Information -->
            @if ($totalPaid > 0)
                <div class="refund-info">
                    <h3 style="margin-top: 0; color: #0369a1;">📋 Informasi Refund</h3>
                    <p>
                        <strong>Total yang Dibayar:</strong> Rp{{ number_format($totalPaid, 0, ',', '.') }}<br>
                        <strong>Kebijakan Refund:</strong> <span class="highlight">50% dari total pembayaran</span><br>
                        <strong>Biaya Administrasi:</strong> 50% (Rp{{ number_format($totalPaid * 0.5, 0, ',', '.') }})
                    </p>
                </div>

                @if ($refundAmount < 0)
                    <!-- Refund Success -->
                    <div class="refund-success">
                        <h3 style="margin-top: 0; color: #16a34a;">✅ Refund Berhasil Diproses</h3>
                        <p>
                            <strong>Jumlah Refund:</strong> Rp{{ number_format(abs($refundAmount), 0, ',', '.') }}<br>
                            <strong>Status:</strong> Telah dikirim ke Midtrans<br>
                            <strong>Estimasi Waktu:</strong> 3-5 hari kerja<br>
                            <strong>Metode Refund:</strong> Otomatis ke metode pembayaran yang sama
                        </p>
                        <p style="font-size: 14px; color: #059669;">
                            💳 Dana akan dikembalikan langsung ke {{ $isQrisPayment ? 'e-wallet/QRIS' : 'rekening' }}
                            yang Anda gunakan saat pembayaran.
                            Tidak perlu memberikan nomor rekening tambahan.
                        </p>
                    </div>
                @elseif($refundFailed < 0)
                    <!-- Refund Failed -->
                    <div class="refund-failed">
                        <h3 style="margin-top: 0; color: #dc2626;">❌ Refund Otomatis Gagal</h3>
                        <p>
                            <strong>Jumlah Refund:</strong> Rp{{ number_format(abs($refundFailed), 0, ',', '.') }}<br>
                            <strong>Status:</strong> Memerlukan proses manual<br>
                            <strong>Tindakan Diperlukan:</strong> Tim kami akan menghubungi Anda
                        </p>
                        <p style="font-size: 14px; color: #dc2626;">
                            📞 Mohon siapkan informasi berikut untuk proses refund manual:<br>
                            • Nomor rekening bank atau e-wallet<br>
                            • Nama pemilik rekening<br>
                            • Screenshot bukti pembayaran
                        </p>
                    </div>
                @elseif(!$isQrisPayment)
                    <!-- Non-QRIS Payment -->
                    <div class="refund-failed">
                        <h3 style="margin-top: 0; color: #dc2626;">ℹ️ Refund Manual Diperlukan</h3>
                        <p>
                            <strong>Jumlah Refund:</strong> Rp{{ number_format($totalPaid * 0.5, 0, ',', '.') }}<br>
                            <strong>Alasan:</strong> Pembayaran tidak menggunakan QRIS<br>
                            <strong>Proses:</strong> Refund manual oleh tim kami
                        </p>
                        <p style="font-size: 14px; color: #dc2626;">
                            📞 Tim kami akan menghubungi Anda dalam 1x24 jam untuk proses refund manual.<br>
                            Mohon siapkan nomor rekening dan nama pemilik rekening.
                        </p>
                    </div>
                @else
                    <!-- Default Refund Info -->
                    <div class="refund-info">
                        <h3 style="margin-top: 0; color: #0369a1;">⏳ Refund Sedang Diproses</h3>
                        <p>
                            <strong>Jumlah Refund:</strong> Rp{{ number_format($totalPaid * 0.5, 0, ',', '.') }}<br>
                            <strong>Status:</strong> Dalam proses<br>
                            <strong>Estimasi:</strong> 3-5 hari kerja
                        </p>
                    </div>
                @endif
            @endif

            <!-- Important Notes -->
            <div
                style="background-color: #fffbeb; border: 1px solid #f59e0b; border-radius: 6px; padding: 16px; margin: 16px 0;">
                <h3 style="margin-top: 0; color: #d97706;">⚠️ Penting untuk Diketahui</h3>
                <ul style="margin: 0; padding-left: 20px;">
                    <li>Refund otomatis hanya tersedia untuk pembayaran QRIS/e-wallet</li>
                    <li>Biaya administrasi pembatalan sebesar 50% sesuai kebijakan</li>
                    <li>Konfirmasi refund akan dikirim via email setelah berhasil diproses</li>
                </ul>
            </div>

            <p>
                Jika Anda memiliki pertanyaan mengenai pembatalan atau refund ini,
                silakan hubungi kami dengan menyertakan nomor reservasi
                <strong>#{{ $reservasi->id_reservation }}</strong>.
            </p>

            <p>Terima kasih atas pengertian Anda.</p>

            <p>Hormat kami,</p>
            <p><em>{{ config('app.name') }}</em></p>

            <p>
                📞 Kontak: +62 812-3456-7890<br>
                📧 Email: info@pondokharibaik.com<br>
                🕒 Jam Operasional: 08:00 - 22:00 WIB
            </p>

            <p style="margin-top: 32px; font-size: 12px; color: #6b7280;">
                Jika Anda tidak merasa membuat pemesanan ini, abaikan email ini atau segera hubungi kami.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Seluruh hak cipta dilindungi.<br>
            Email ini dikirim otomatis, mohon tidak membalas email ini.
        </div>
    </div>
</body>

</html>
