<?php
/**
 * File: config/database.php
 * Keterangan: Konfigurasi koneksi database menggunakan PDO untuk Laragon.
 * Gambar/Asset: Tidak ada gambar di file ini (backend config).
 */

$host = 'localhost';
$dbname = 'db_spk_urticaria';
$username = 'root';
$password = ''; // Default password Laragon kosong

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set error mode ke exception untuk debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>