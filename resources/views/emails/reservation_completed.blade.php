<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Konfirmasi Reservasi & Invoice</title>
    <style>
        /* Reset & Base */
        body,
        h1,
        h2,
        h3,
        p,
        ul {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f5f5f5;
            color: #333;
            line-height: 1.5;
        }

        ul {
            list-style: none;
        }

        /* Container */
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* Header */
        .header {
            background: #2c3e50;
            color: #fff;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            font-size: 20px;
            font-weight: normal;
        }

        /* Body */
        .body {
            padding: 20px;
        }

        .body h2 {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .body p {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        /* Section */
        .section {
            border: 1px solid #eaeaea;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .section-header {
            background: #f8f9fa;
            padding: 10px 15px;
        }

        .section-header h3 {
            font-size: 16px;
            color: #2c3e50;
        }

        .section-content {
            padding: 15px;
        }

        .info-list li {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        /* Highlight */
        .highlight {
            background: #f8f9fa;
            border-left: 4px solid #3490dc;
            padding: 15px;
            margin: 15px 0;
            font-size: 14px;
        }

        /* Button */
        .btn {
            display: inline-block;
            background: #3490dc;
            color: #fff !important;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 4px;
            font-size: 14px;
            text-align: center;
        }

        .btn:hover {
            background: #2779bd;
        }

        /* Footer */
        .footer {
            background: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .footer a {
            color: #3490dc;
            text-decoration: none;
            margin: 0 5px;
        }

        @media (max-width: 480px) {
            .info-list li {
                flex-direction: column;
            }

            .info-list li div {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Pondok Hari Baik – Konfirmasi Reservasi</h1>
        </div>

        <div class="body">
            <h2>Halo {{ $reservasi->guest->full_name }},</h2>
            <p>Terima kasih telah memilih <strong>Pondok Hari Baik</strong>. Berikut detail reservasi dan pembayaran
                Anda:</p>

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

            <div class="highlight">
                Invoice lengkap terlampir dalam PDF. Simpan email ini sebagai bukti reservasi Anda.
            </div>

            <p style="text-align:center;">
                <a href="{{ url('/') }}" class="btn">Kunjungi Website Kami</a>
            </p>

            <p style="font-size:13px; color:#555; margin-top:20px;">
                Butuh bantuan? Hubungi <a href="mailto:info@pondokharibaik.com">info@pondokharibaik.com</a> atau +62 123
                4567 890.
            </p>
        </div>

        <div class="footer">
            <div>
                <a href="#">Facebook</a>|
                <a href="#">Instagram</a>|
                <a href="#">Twitter</a>
            </div>
            <p>Pondok Hari Baik • Jl. Kebahagiaan No. 123, Bali</p>
            <p>&copy; {{ date('Y') }} Pondok Hari Baik. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
