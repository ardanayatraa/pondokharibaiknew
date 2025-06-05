<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Perihal: Konfirmasi Reservasi & Invoice #{{ $reservasi->id_reservation }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 24px auto;
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #1f2937;
            color: #fff;
            text-align: center;
            padding: 16px 24px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: normal;
        }

        .body {
            padding: 24px;
            line-height: 1.6;
        }

        .section {
            border: 1px solid #eaeaea;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .section-header {
            background-color: #f8f9fa;
            padding: 12px 16px;
        }

        .section-header h3 {
            font-size: 16px;
            color: #2c3e50;
            margin: 0;
        }

        .section-content {
            padding: 16px;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
            font-size: 14px;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .highlight {
            background-color: #f8f9fa;
            border-left: 4px solid #3490dc;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            background-color: #3490dc;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
            margin-top: 16px;
        }

        .btn:hover {
            background-color: #2779bd;
        }

        .footer {
            background-color: #f3f4f6;
            padding: 16px 24px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        @media (max-width: 480px) {
            .info-list li {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <h1>Perihal: Konfirmasi Reservasi & Invoice #{{ $reservasi->id_reservation }}</h1>
        </div>

        <!-- Body -->
        <div class="body">
            <p>Halo <strong>{{ $reservasi->guest->full_name }}</strong>,</p>

            <p>
                Terima kasih telah memilih <strong>Pondok Hari Baik</strong>. Berikut adalah detail reservasi dan
                pembayaran Anda:
            </p>

            <!-- Section: Detail Reservasi -->
            <div class="section">
                <div class="section-header">
                    <h3>Detail Reservasi</h3>
                </div>
                <div class="section-content">
                    <ul class="info-list">
                        <li>
                            <div>ID Reservasi</div>
                            <div>{{ $reservasi->id_reservation }}</div>
                        </li>
                        <li>
                            <div>Villa</div>
                            <div>{{ $reservasi->villa->name }}</div>
                        </li>
                        <li>
                            <div>Check-in</div>
                            <div>{{ \Carbon\Carbon::parse($reservasi->start_date)->format('d M Y') }}</div>
                        </li>
                        <li>
                            <div>Check-out</div>
                            <div>{{ \Carbon\Carbon::parse($reservasi->end_date)->format('d M Y') }}</div>
                        </li>
                        <li>
                            <div>Lama Menginap</div>
                            <div>{{ $nights }} malam</div>
                        </li>
                        <li>
                            <div>Total</div>
                            <div><strong>Rp {{ number_format($reservasi->total_amount, 0, ',', '.') }}</strong></div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Section: Data Tamu -->
            <div class="section">
                <div class="section-header">
                    <h3>Data Tamu</h3>
                </div>
                <div class="section-content">
                    <ul class="info-list">
                        <li>
                            <div>Nama</div>
                            <div>{{ $reservasi->guest->full_name }}</div>
                        </li>
                        <li>
                            <div>Email</div>
                            <div>{{ $reservasi->guest->email }}</div>
                        </li>
                        <li>
                            <div>Alamat</div>
                            <div>{{ $reservasi->guest->address }}</div>
                        </li>
                        <li>
                            <div>No. HP</div>
                            <div>{{ $reservasi->guest->phone_number }}</div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Section: Informasi Pembayaran -->
            <div class="section">
                <div class="section-header">
                    <h3>Informasi Pembayaran</h3>
                </div>
                <div class="section-content">
                    <ul class="info-list">
                        <li>
                            <div>No. Pembayaran</div>
                            <div>{{ $pembayaran->id_pembayaran }}</div>
                        </li>
                        <li>
                            <div>Tanggal Bayar</div>
                            <div>{{ \Carbon\Carbon::parse($pembayaran->payment_date)->format('d M Y H:i') }}</div>
                        </li>
                        <li>
                            <div>Jumlah</div>
                            <div><strong>Rp {{ number_format($pembayaran->amount, 0, ',', '.') }}</strong></div>
                        </li>
                        <li>
                            <div>Status</div>
                            <div>
                                <span style="background:#d4edda;color:#155724;padding:4px 8px;border-radius:4px;">
                                    {{ ucfirst($pembayaran->status) }}
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Highlight Note -->
            <div class="highlight">
                Invoice lengkap terlampir dalam PDF ini.
                Mohon simpan email ini sebagai bukti sah reservasi Anda.
            </div>

            <p style="font-size:13px; color:#555; margin-top:20px;">
                Jika ada pertanyaan atau bantuan lebih lanjut, silakan hubungi:
                <a href="mailto:info@pondokharibaik.id">info@pondokharibaik.id</a> atau WhatsApp <strong>+62
                    812-3456-7890</strong>.
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Seluruh hak cipta dilindungi.
        </div>

    </div>
</body>

</html>
