<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Hasil Transaksi Snap</title>
</head>

<body>
    <h2>Hasil Transaksi</h2>
    <p><strong>Tipe:</strong> {{ $type }}</p>
    <pre>{{ print_r($data, true) }}</pre>
    <a href="/test-snap">← Kembali ke test-snap</a>
</body>

</html>
