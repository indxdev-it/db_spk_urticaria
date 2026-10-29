<?php
/**
 * File: admin/gejala.php
 * Keterangan: Form admin untuk menambah dan mengelola data gejala (GP01 - GP25).
 */
session_start();
require_once '../config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Proses Tambah Gejala
$pesan = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah_gejala'])) {
    $kode_gejala = trim($_POST['kode_gejala']);
    $nama_gejala = trim($_POST['nama_gejala']);
    $status = trim($_POST['status']);

    if (!empty($kode_gejala) && !empty($nama_gejala)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO gejala (kode_gejala, nama_gejala, status) VALUES (?, ?, ?)");
            $stmt->execute([$kode_gejala, $nama_gejala, $status]);
            $pesan = "Gejala berhasil ditambahkan!";
        } catch (PDOException $e) {
            $pesan = "Gagal: Kode gejala sudah ada atau database error.";
        }
    }
}

// Ambil semua daftar gejala
$gejala_list = $pdo->query("SELECT * FROM gejala ORDER BY kode_gejala ASC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Gejala - Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <navbar>
        <div class="nav-container">
            <div class="nav-logo"><span style="font-weight:700; color:var(--primary-color);">Panel Admin</span></div>
            <ul class="nav-menu">
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="gejala.php" class="active">Kelola Gejala</a></li>
                <li><a href="../auth/logout.php" style="color: #ef4444;">Logout</a></li>
            </ul>
        </div>
    </navbar>

    <div style="max-width: 1000px; margin: 3rem auto; padding: 0 2rem;" class="reveal">
        <h2 style="margin-bottom: 0.5rem; color: var(--text-main);">Basis Pengetahuan / Gejala</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Kelola daftar gejala untuk proses konsultasi alergi akibat suhu dingin[cite: 1].</p>

        <?php if($pesan): ?>
            <div style="background: #e0f2fe; color: #0369a1; padding: 10px; border-radius: 6px; margin-bottom: 1.5rem;"><?= $pesan; ?></div>
        <?php endif; ?>

        <!-- Form Tambah Gejala -->
        <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 2rem;">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Tambah Gejala Baru</h3>
            <form method="POST" style="display: grid; grid-template-columns: 150px 1fr 150px 120px; gap: 1rem; align-items: center;">
                <input type="text" name="kode_gejala" placeholder="Kode (mis: GP26)" required style="padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;">
                <input type="text" name="nama_gejala" placeholder="Nama gejala..." required style="padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;">
                <select name="status" style="padding: 8px; border: 1px solid #cbd5e1; border-radius: 6px;">
                    <option value="Utama">Utama</option>
                    <option value="Pendukung">Pendukung</option>
                </select>
                <button type="submit" name="tambah_gejala" class="btn-primary" style="padding: 8px;">Simpan</button>
            </form>
        </div>

        <!-- Tabel Daftar Gejala -->
        <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <h3 style="margin-bottom: 1rem; font-size: 1.1rem;">Daftar Gejala Terdaftar</h3>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 10px; width: 15%;">Kode</th>
                            <th style="padding: 10px; width: 55%;">Nama Gejala</th>
                            <th style="padding: 10px; width: 20%;">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($gejala_list as $row): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px; font-weight: 600; color: var(--primary-color);"><?= htmlspecialchars($row['kode_gejala']); ?></td>
                            <td style="padding: 10px;"><?= htmlspecialchars($row['nama_gejala']); ?></td>
                            <td style="padding: 10px;"><?= htmlspecialchars($row['status']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>