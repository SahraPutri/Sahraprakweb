<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Kehadiran</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f9fbfc; padding: 30px; color: #2c3e50; }
        .nav { margin-bottom: 25px; padding: 15px; background: #3498db; border-radius: 8px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; font-weight: bold; }
        .nav a:hover { text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-top: 20px; }
        th, td { padding: 12px 16px; border-bottom: 1px solid #eee; }
        th { background-color: #2980b9; color: white; text-align: left; }
        button { padding: 6px 12px; border: none; border-radius: 5px; font-weight: bold; color: white; cursor: pointer; }
        .btn-hadir { background-color: #2ecc71; }
        .btn-tidak { background-color: #e74c3c; }
        input, select { padding: 8px; margin-right: 10px; border: 1px solid #ccc; border-radius: 5px; }
    </style>
</head>
<body>

<div class="nav">
    <a href="index.php">🏠 Pendaftaran</a>
    <a href="kategori_event.php">📂 Kategori Event</a>
    <a href="penyelenggara.php">👥 Penyelenggara</a>
    <a href="kehadiran.php">✅ Kehadiran</a>
</div>

<form method="POST">
    <select name="id_pendaftaran" required>
        <option value="">-- Pilih Pendaftaran --</option>
        <?php
        $pendaftar = mysqli_query($koneksi, "SELECT pd.id, ps.nama, ev.nama_event FROM pendaftaran pd JOIN peserta ps ON pd.id_peserta = ps.id_peserta JOIN event ev ON pd.id_event = ev.id_event WHERE pd.id NOT IN (SELECT id_pendaftaran FROM kehadiran)");
        while ($p = mysqli_fetch_array($pendaftar)) {
            echo "<option value='$p[id]'>$p[nama] - $p[nama_event]</option>";
        }
        ?>
    </select>
    <select name="status_hadir" required>
        <option value="Hadir">Hadir</option>
        <option value="Tidak Hadir">Tidak Hadir</option>
    </select>
    <button name="tambah_kehadiran" class="btn-hadir">+ Simpan</button>
</form>

<?php
if (isset($_POST['tambah_kehadiran'])) {
    $id = $_POST['id_pendaftaran'];
    $status = $_POST['status_hadir'];
    $waktu = $status == 'Hadir' ? date('Y-m-d H:i:s') : NULL;
    mysqli_query($koneksi, "INSERT INTO kehadiran (id_pendaftaran, status_hadir, waktu_absen) VALUES ('$id', '$status', " . ($waktu ? "'$waktu'" : "NULL") . ")");
}
if (isset($_POST['update_kehadiran'])) {
    $id = $_POST['id_pendaftaran'];
    $status = $_POST['status_hadir'];
    $waktu = $status == 'Hadir' ? date('Y-m-d H:i:s') : "NULL";
    mysqli_query($koneksi, "UPDATE kehadiran SET status_hadir='$status', waktu_absen=" . ($waktu == "NULL" ? "NULL" : "'$waktu'") . " WHERE id_pendaftaran=$id");
}
?>

<h2>Data Kehadiran</h2>
<table>
    <tr><th>Peserta</th><th>Event</th><th>Status</th><th>Waktu</th><th>Aksi</th></tr>
    <?php
    $data = mysqli_query($koneksi, "SELECT k.*, ps.nama, ev.nama_event FROM kehadiran k JOIN pendaftaran pd ON k.id_pendaftaran = pd.id JOIN peserta ps ON pd.id_peserta = ps.id_peserta JOIN event ev ON pd.id_event = ev.id_event");
    while ($h = mysqli_fetch_array($data)) {
        echo "<tr>
            <td>$h[nama]</td><td>$h[nama_event]</td>
            <td><strong>$h[status_hadir]</strong></td>
            <td>".($h['waktu_absen'] ?? '-')."</td>
            <td>
                <form method='POST' style='display:inline'>
                    <input type='hidden' name='id_pendaftaran' value='$h[id_pendaftaran]'>
                    <input type='hidden' name='status_hadir' value='Hadir'>
                    <button name='update_kehadiran' class='btn-hadir'>✓ Hadir</button>
                </form>
                <form method='POST' style='display:inline'>
                    <input type='hidden' name='id_pendaftaran' value='$h[id_pendaftaran]'>
                    <input type='hidden' name='status_hadir' value='Tidak Hadir'>
                    <button name='update_kehadiran' class='btn-tidak'>✗ Tidak</button>
                </form>
            </td>
        </tr>";
    }
    ?>
</table>

</body>
</html>