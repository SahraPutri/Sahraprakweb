<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Pendaftaran</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f9fbfc; margin: 0; }
        .container { max-width: 700px; margin: 40px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .nav { margin-bottom: 25px; padding: 15px; background: #3498db; border-radius: 8px; }
        .nav a { color: white; margin-right: 20px; text-decoration: none; font-weight: bold; }
        h2 { margin-bottom: 20px; }
        label { display: block; margin-top: 15px; margin-bottom: 6px; font-weight: 600; }
        input, select {
            width: 100%; padding: 10px;
            border: 1px solid #ccc; border-radius: 6px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background: #f39c12;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
        }
        #eventInfo {
            margin-top: 10px;
            background: #f0f8ff;
            padding: 10px 15px;
            border-radius: 6px;
            color: #333;
            font-size: 0.95em;
        }
    </style>
</head>
<body>
<div class="container">

<div class="nav">
    <a href="index.php">🏠 Pendaftaran</a>
    <a href="kategori_event.php">📂 Kategori</a>
    <a href="penyelenggara.php">👥 Penyelenggara</a>
    <a href="kehadiran.php">✅ Kehadiran</a>
</div>

<h2>Edit Pendaftaran</h2>

<?php
$id = $_GET['id'];
$q = mysqli_query($koneksi, "
    SELECT p.id, ps.nama, ps.email, ps.no_hp, p.id_event, p.tanggal_daftar, p.status
    FROM pendaftaran p
    JOIN peserta ps ON p.id_peserta = ps.id_peserta
    WHERE p.id = $id
");
$data = mysqli_fetch_array($q);
?>

<form method="POST">
    <label>Nama Peserta:</label>
    <input type="text" name="nama" value="<?= $data['nama'] ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?= $data['email'] ?>" required>

    <label>No. HP:</label>
    <input type="text" name="no_hp" value="<?= $data['no_hp'] ?>" required>

    <label>Event:</label>
    <select name="id_event" id="eventSelect" required onchange="updateInfo()">
        <option value="">-- Pilih Event --</option>
        <?php
        $event = mysqli_query($koneksi, "
            SELECT e.id_event, e.nama_event, k.nama_kategori, p.nama_penyelenggara
            FROM event e
            JOIN kategori_event k ON e.id_kategori = k.id_kategori
            JOIN penyelenggara p ON e.id_penyelenggara = p.id_penyelenggara
        ");
        while ($e = mysqli_fetch_array($event)) {
            $selected = ($e['id_event'] == $data['id_event']) ? 'selected' : '';
            echo "<option value='$e[id_event]' data-kategori='$e[nama_kategori]' data-penyelenggara='$e[nama_penyelenggara]' $selected>
                    $e[nama_event]
                  </option>";
        }
        ?>
    </select>

    <div id="eventInfo"></div>

    <label>Tanggal Daftar:</label>
    <input type="date" name="tanggal_daftar" value="<?= $data['tanggal_daftar'] ?>" required>

    <label>Status:</label>
    <select name="status" required>
        <option value="Menunggu" <?= ($data['status'] == 'Menunggu' ? 'selected' : '') ?>>Menunggu</option>
        <option value="Terkonfirmasi" <?= ($data['status'] == 'Terkonfirmasi' ? 'selected' : '') ?>>Terkonfirmasi</option>
    </select>

    <button type="submit" name="update">Simpan Perubahan</button>
</form>

<?php
if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $id_event = $_POST['id_event'];
    $tanggal = $_POST['tanggal_daftar'];
    $status = $_POST['status'];

    // Update peserta
    mysqli_query($koneksi, "UPDATE peserta SET nama='$nama', email='$email', no_hp='$no_hp' 
                            WHERE id_peserta = (SELECT id_peserta FROM pendaftaran WHERE id=$id)");

    // Update pendaftaran
    mysqli_query($koneksi, "UPDATE pendaftaran SET id_event=$id_event, tanggal_daftar='$tanggal', status='$status' 
                            WHERE id=$id");

    echo "<script>alert('Data berhasil diubah'); window.location='index.php';</script>";
}
?>

</div>

<script>
function updateInfo() {
    var select = document.getElementById('eventSelect');
    var selected = select.options[select.selectedIndex];
    var kategori = selected.getAttribute('data-kategori') || '';
    var penyelenggara = selected.getAttribute('data-penyelenggara') || '';
    var info = document.getElementById('eventInfo');

    if (kategori && penyelenggara) {
        info.innerHTML = "Kategori: <strong>" + kategori + "</strong><br>Penyelenggara: <strong>" + penyelenggara + "</strong>";
    } else {
        info.innerHTML = "";
    }
}
window.onload = updateInfo;
</script>

</body>
</html>