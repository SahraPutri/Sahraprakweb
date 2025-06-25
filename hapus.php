<?php
include 'koneksi.php';
$id = $_GET['id'];

// Hapus dulu data kehadiran (agar relasi tidak error)
mysqli_query($koneksi, "DELETE FROM kehadiran WHERE id_pendaftaran = $id");

// Baru hapus data pendaftaran
mysqli_query($koneksi, "DELETE FROM pendaftaran WHERE id = $id");

header("Location: index.php");
?>