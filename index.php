<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran</title>
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
        a.edit { color: #2980b9; text-decoration: none; margin-right: 10px; }
        .add-button { margin-bottom: 15px; }
        .add-button a {
            text-decoration: none;
            background-color: #2ecc71;
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
        }
        .add-button a:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

<div class="nav">
    <a href="index.php">🏠 Pendaftaran</a>
    <a href="kategori_event.php">📂 Kategori Event</a>
    <a href="penyelenggara.php">👥 Penyelenggara</a>
    <a href="kehadiran.php">✅ Kehadiran</a>
</div>

<h2>Pendaftaran</h2>

<div class="add-button">
    <a href="tambah.php">+ Tambah Pendaftaran</a>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Peserta</th>
        <th>Email</th>
        <th>No. HP</th>
        <th>Event</th>
        <th>Kategori</th>
        <th>Penyelenggara</th>
        <th>Tanggal Daftar</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php
    $query = mysqli_query($koneksi, "
        SELECT p.id, ps.nama, ps.email, ps.no_hp, e.nama_event, k.nama_kategori, py.nama_penyelenggara,
               p.tanggal_daftar, p.status
        FROM pendaftaran p
        JOIN peserta ps ON p.id_peserta = ps.id_peserta
        JOIN event e ON p.id_event = e.id_event
        JOIN kategori_event k ON e.id_kategori = k.id_kategori
        JOIN penyelenggara py ON e.id_penyelenggara = py.id_penyelenggara
        ORDER BY p.id DESC
    ");
    while ($row = mysqli_fetch_array($query)) {
        echo "<tr>
                <td>$row[id]</td>
                <td>$row[nama]</td>
                <td>$row[email]</td>
                <td>$row[no_hp]</td>
                <td>$row[nama_event]</td>
                <td>$row[nama_kategori]</td>
                <td>$row[nama_penyelenggara]</td>
                <td>$row[tanggal_daftar]</td>
                <td><strong>$row[status]</strong></td>
                <td>
                    <a class='edit' href='edit.php?id=$row[id]'>Edit</a>
                    <a class='hapus' href='hapus.php?id=$row[id]' onclick=\"return confirm('Yakin ingin menghapus?')\">Hapus</a>
                </td>
            </tr>";
    }
    ?>
</table>

</body>
</html>