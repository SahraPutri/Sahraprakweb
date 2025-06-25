<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Penyelenggara</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f9fbfc; padding: 30px; color: #2c3e50; }
        .nav { margin-bottom: 25px; padding: 15px; background: #3498db; border-radius: 8px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; font-weight: bold; }
        .nav a:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-top: 20px; }
        th, td { padding: 12px 16px; border-bottom: 1px solid #eee; }
        th { background-color: #2980b9; color: white; text-align: left; }
        input { padding: 8px; margin-right: 10px; border: 1px solid #ccc; border-radius: 5px; }
        button { padding: 6px 12px; border: none; border-radius: 5px; background-color: #2ecc71; color: white; font-weight: bold; }
        a.hapus { color: #e74c3c; text-decoration: none; }
    </style>
</head>
<body>

<div class="nav">
    <a href="index.php">🏠 Pendaftaran</a>
    <a href="kategori_event.php">📂 Kategori Event</a>
    <a href="penyelenggara.php">👥 Penyelenggara</a>
    <a href="kehadiran.php">✅ Kehadiran</a>
</div>

<h2>Penyelenggara</h2>
<form method="POST">
    <input type="text" name="nama_penyelenggara" placeholder="Nama Penyelenggara" required>
    <input type="text" name="kontak" placeholder="Kontak (opsional)">
    <button name="tambah_penyelenggara">Tambah</button>
</form>

<?php
if (isset($_POST['tambah_penyelenggara'])) {
    $nama = $_POST['nama_penyelenggara'];
    $kontak = $_POST['kontak'];
    mysqli_query($koneksi, "INSERT INTO penyelenggara (nama_penyelenggara, kontak) VALUES ('$nama', '$kontak')");
}
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM penyelenggara WHERE id_penyelenggara=$id");
}
$data = mysqli_query($koneksi, "SELECT * FROM penyelenggara");
?>

<table>
    <tr><th>Nama</th><th>Kontak</th><th>Aksi</th></tr>
    <?php while ($d = mysqli_fetch_array($data)) {
        echo "<tr><td>$d[nama_penyelenggara]</td><td>$d[kontak]</td>
        <td><a href='?hapus=$d[id_penyelenggara]' class='hapus' onclick=\"return confirm('Hapus?')\">Hapus</a></td></tr>";
    } ?>
</table>

</body>
</html>