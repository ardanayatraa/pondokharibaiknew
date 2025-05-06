<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dummy Email untuk Tamu</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .card {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            line-height: 1.4;
        }

        ul {
            margin: 10px 0 20px;
            padding-left: 20px;
        }

        li {
            margin-bottom: 6px;
        }

        .footer {
            font-size: 12px;
            color: #999;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h1>Halo {{ $nama ?? 'Nama Tamu' }},</h1>

        <p>Ini adalah email <strong>dummy</strong> untuk menguji template sebelum data asli dikirim.</p>

        <ul>
            <li><strong>Nomor Reservasi:</strong> DUMMY-20250426-001</li>
            <li><strong>Tanggal Check-in:</strong> 1 Mei 2025</li>
            <li><strong>Tanggal Check-out:</strong> 3 Mei 2025</li>
            <li><strong>Jenis Vila:</strong> Vila Puri Bali</li>
            <li><strong>Jumlah Tamu:</strong> 2 Orang</li>
        </ul>

        <p>Terima kasih telah memilih Pondok Hari Baik Villa.
            Kami tunggu kunjungan Anda!</p>

        <p class="footer">
            &copy; 2025 Pondok Hari Baik Villa
        </p>
    </div>
</body>

</html>
