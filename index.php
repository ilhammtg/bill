<!DOCTYPE html>
<html>
<head>
    <title>Rumah Makan</title>
</head>
<body>
    <form action="" method="post">
        <label for="nomor_meja">Nomor Meja:</label><br>
        <input type="number" id="nomor_meja" name="nomor_meja"><br>
        <label for="pesanan_makanan">Pesanan Makanan:</label><br>
        <select id="pesanan_makanan" name="pesanan_makanan">
            <option value="Nasi Goreng">Nasi Goreng</option>
            <option value="Mie Ayam">Mie Ayam</option>
            <option value="Sate Ayam">Sate Ayam</option>
            <option value="Bakso">Bakso</option>
            <option value="Soto">Soto</option>
        </select>
        <input type="number" id="jumlah_makanan" name="jumlah_makanan"><br>
        <label for="pesanan_minuman">Pesanan Minuman:</label><br>
        <select id="pesanan_minuman" name="pesanan_minuman">
            <option value="Es Teh">Es Teh</option>
            <option value="Es Jeruk">Es Jeruk</option>
            <option value="Air Mineral">Air Mineral</option>
            <option value="Jus Alpukat">Jus Alpukat</option>
            <option value="Kopi">Kopi</option>
        </select>
        <input type="number" id="jumlah_minuman" name="jumlah_minuman"><br>
        <label for="uang_bayar">Uang Bayar:</label><br>
        <input type="number" id="uang_bayar" name="uang_bayar" step="any"><br>
        <input type="submit" value="Submit">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Stok makanan dan minuman
        $stok = [
            'makanan' => ['Nasi Goreng' => 10, 'Mie Ayam' => 5, 'Sate Ayam' => 7, 'Bakso' => 8, 'Soto' => 6],
            'minuman' => ['Es Teh' => 10, 'Es Jeruk' => 7, 'Air Mineral' => 15, 'Jus Alpukat' => 5, 'Kopi' => 8]
        ];

        // Harga makanan dan minuman
        $harga = [
            'makanan' => ['Nasi Goreng' => 15000, 'Mie Ayam' => 12000, 'Sate Ayam' => 20000, 'Bakso' => 10000, 'Soto' => 8000],
            'minuman' => ['Es Teh' => 5000, 'Es Jeruk' => 7000, 'Air Mineral' => 3000, 'Jus Alpukat' => 10000, 'Kopi' => 8000]
        ];

        // Ambil data dari form
        $nomor_meja = $_POST["nomor_meja"];
        $pesanan_makanan = $_POST["pesanan_makanan"];
        $jumlah_makanan = $_POST["jumlah_makanan"];
        $pesanan_minuman = $_POST["pesanan_minuman"];
        $jumlah_minuman = $_POST["jumlah_minuman"];
        $uang_bayar = $_POST["uang_bayar"];

        // Cek stok makanan
        if ($stok['makanan'][$pesanan_makanan] < $jumlah_makanan) {
            echo "<script>alert('Stok makanan tidak tersedia.');</script>";
            return;
        }

        // Cek stok minuman
        if ($stok['minuman'][$pesanan_minuman] < $jumlah_minuman) {
            echo "<script>alert('Stok minuman tidak tersedia.');</script>";
            return;
        }

        // Hitung total biaya
        $biaya_makanan = $harga['makanan'][$pesanan_makanan] * $jumlah_makanan;
        $biaya_minuman = $harga['minuman'][$pesanan_minuman] * $jumlah_minuman;
        $biaya = $biaya_makanan + $biaya_minuman;

        // Cek uang bayar
        if ($uang_bayar < $biaya) {
            echo "<script>alert('Uang bayar tidak cukup.');</script>";
            return;
        }

        // Hitung kembalian
        $kembalian = $uang_bayar - $biaya;

        // Kurangi stok
        $stok['makanan'][$pesanan_makanan] -= $jumlah_makanan;
        $stok['minuman'][$pesanan_minuman] -= $jumlah_minuman;

        // Output
        header("location: output.php");
        $output = "Nomor Meja: $nomor_meja\nPesanan: $pesanan_makanan ($jumlah_makanan), $pesanan_minuman ($jumlah_minuman)\nBiaya Makanan: Rp$biaya_makanan\nBiaya Minuman: Rp$biaya_minuman\nTotal Biaya: Rp$biaya\nNominal Bayar: Rp$uang_bayar\nKembalian: Rp$kembalian";

        // Redirect output to new tab
        echo "<script>window.open('data:text/plain;charset=utf-8,' + encodeURIComponent('$output'));</script>";
        header("Location: output.php?data=" . urlencode($output));
        exit;
    }
    ?>
</body>
</html>
