CREATE DATABASE seminar_db;
USE seminar_db;

CREATE TABLE peserta (
    id_peserta INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    email VARCHAR(100),
    no_hp VARCHAR(20)
);

CREATE TABLE kategori_event (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(50)
);

CREATE TABLE penyelenggara (
    id_penyelenggara INT AUTO_INCREMENT PRIMARY KEY,
    nama_penyelenggara VARCHAR(100),
    kontak_penyelenggara VARCHAR(20)
);

CREATE TABLE event (
    id_event INT AUTO_INCREMENT PRIMARY KEY,
    nama_event VARCHAR(100),
    tanggal_event DATE,
    lokasi VARCHAR(150),
    id_kategori INT,
    id_penyelenggara INT,
    FOREIGN KEY (id_kategori) REFERENCES kategori_event(id_kategori),
    FOREIGN KEY (id_penyelenggara) REFERENCES penyelenggara(id_penyelenggara)
);

CREATE TABLE pendaftaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_peserta INT,
    id_event INT,
    tanggal_daftar DATE,
    status ENUM('Menunggu', 'Terkonfirmasi'),
    FOREIGN KEY (id_peserta) REFERENCES peserta(id_peserta),
    FOREIGN KEY (id_event) REFERENCES event(id_event)
);

CREATE TABLE kehadiran (
    id_kehadiran INT AUTO_INCREMENT PRIMARY KEY,
    id_pendaftaran INT,
    status_hadir ENUM('Hadir', 'Tidak Hadir'),
    waktu_absen DATETIME,
    FOREIGN KEY (id_pendaftaran) REFERENCES pendaftaran(id)
);
