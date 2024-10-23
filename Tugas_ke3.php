<?php
session_start();

// Simulasi data produk
if (!isset($_SESSION['produk'])) {
    $_SESSION['produk'] = [];
}

// Fungsi untuk menghitung total harga
function hitungTotalHarga($harga, $jumlah) {
    return $harga * $jumlah;
}

// Menghitung total penjualan keseluruhan dan total jumlah terjual
$total_penjualan = 0;
$total_jumlah_terjual = 0;

// Tambah produk baru jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $harga = (int)$_POST['harga'];
    $jumlah = (int)$_POST['jumlah'];

    $_SESSION['produk'][] = [
        'nama' => $nama,
        'harga' => $harga,
        'jumlah' => $jumlah
    ];
}

// Hitung total penjualan dan total jumlah terjual
foreach ($_SESSION['produk'] as $p) {
    $total_penjualan += hitungTotalHarga($p['harga'], $p['jumlah']);
    $total_jumlah_terjual += $p['jumlah'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
</head>
<body>
    <h2>Laporan Penjualan</h2>

    <form method="post">
        <label for="nama">Nama Produk:</label>
        <input type="text" id="nama" name="nama" required>
        <br>
        <label for="harga">Harga:</label>
        <input type="number" id="harga" name="harga" required>
        <br>
        <label for="jumlah">Jumlah:</label>
        <input type="number" id="jumlah" name="jumlah" required>
        <br>
        <button type="submit">Tambah Produk</button>
    </form>

    <table border="1" cellpadding="5" cellspacing="0" style="margin-top: 20px;">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga Per Produk</th>
                <th>Jumlah Terjual</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['produk'] as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['nama']) ?></td>
                <td><?= number_format($p['harga'], 0, ',', '.') ?></td>
                <td><?= $p['jumlah'] ?></td>
                <td><?= number_format(hitungTotalHarga($p['harga'], $p['jumlah']), 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2"><strong>Total Jumlah Terjual</strong></td>
                <td><strong><?= $total_jumlah_terjual ?></strong></td>
                <td><strong><?= number_format($total_penjualan, 0, ',', '.') ?></strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>