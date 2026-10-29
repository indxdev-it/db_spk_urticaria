<?php
/**
 * File: admin/index.php
 * Keterangan: Dashboard utama khusus Admin untuk mengelola basis pengetahuan sistem pakar.
 */
session_start();
require_once '../config/database.php';

// Validasi hak akses: pastikan user sudah login dan rolenya adalah 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak! Anda bukan admin.'); window.location='../auth/login.php';</script>";
    exit;
}

// Ambil statistik ringkas untuk ditampilkan di dashboard
$total_gejala = $pdo->query("SELECT COUNT(*) FROM gejala")->fetchColumn();
$total_kondisi = $pdo->query("SELECT COUNT(*) FROM kondisi")->fetchColumn();
$total_konsultasi = $pdo->query("SELECT COUNT(*) FROM konsultasi")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Sistem Pakar Cold Urticaria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <!-- Navbar Admin -->
    <navbar>
        <div class="nav-container">
            <div class="nav-logo">
                <span style="font-weight:700; color:var(--primary-color); font-size:1.2rem;">Panel Admin - Urticaria</span>
            </div>
            <ul class="nav-menu">
                <li><a href="index.php" class="active">Dashboard</a></li>
                <li><a href="gejala.php">Kelola Gejala</a></li>
                <li><a href="../index.php">Ke Website Utama</a></li>
                <li><a href="../auth/logout.php" style="color: #ef4444;">Logout</a></li>
            </ul>
        </div>
    </navbar>

    <!-- Konten Dashboard -->
    <div style="max-width: 1000px; margin: 3rem auto; padding: 0 2rem;" class="reveal">
        <h2 style="margin-bottom: 0.5rem; color: var(--text-main);">Selamat Datang, <?= htmlspecialchars($_SESSION['nama']); ?>!</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Berikut adalah ringkasan data basis pengetahuan sistem pakar deteksi dini cold urticaria.</p>

        <!-- Kartu Statistik -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2.5rem;">
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border-left: 4px solid var(--primary-color);">
                <h4 style="color: var(--text-muted); font-size: 0.9rem;">Total Gejala</h4>
                <p style="font-size: 2rem; font-weight: bold; color: var(--text-main); margin-top: 5px;"><?= $total_gejala; ?></p>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border-left: 4px solid #38bdf8;">
                <h4 style="color: var(--text-muted); font-size: 0.9rem;">Kondisi Penyakit</h4>
                <p style="font-size: 2rem; font-weight: bold; color: var(--text-main); margin-top: 5px;"><?= $total_kondisi; ?></p>
            </div>
            <div style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); border-left: 4px solid #10b981;">
                <h4 style="color: var(--text-muted); font-size: 0.9rem;">Total Konsultasi Pengguna</h4>
                <p style="font-size: 2rem; font-weight: bold; color: var(--text-main); margin-top: 5px;"><?= $total_konsultasi; ?></p>
            </div>
        </div>

        <!-- Menu Pintas / Aksi Admin -->
        <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <h3 style="margin-bottom: 1rem; color: var(--text-main);">Navigasi Pengelolaan</h3>
            <p style="color: var(--text-muted); margin-bottom: 1.5rem;">Pilih menu di bawah ini untuk menambah atau mengubah data basis aturan dan gejala yang digunakan dalam metode Certainty Factor[cite: 1].</p>
            <div style="display: flex; gap: 1rem;">
                <a href="gejala.php" class="btn-primary" style="text-decoration: none;">Kelola Data Gejala</a>
            </div>
        </div>
    </div>
</body>
</html>