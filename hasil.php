<?php
/**
 * File: hasil.php
 * Keterangan: Menampilkan hasil akhir perhitungan CF dan saran medis/pencegahan.
 */
session_start();
require_once 'config/database.php';

$id_konsultasi = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT * FROM konsultasi WHERE id_konsultasi = ?");
$stmt->execute([$id_konsultasi]);
$hasil = $stmt->fetch();

if (!$hasil) {
    echo "Data konsultasi tidak ditemukan.";
    exit;
}

// Ambil detail gejala yang dipilih
$stmtDetail = $pdo->prepare("
    SELECT g.nama_gejala, dk.cf_user, dk.cf_evidence 
    FROM detail_konsultasi dk 
    JOIN gejala g ON dk.id_gejala = g.id_gejala 
    WHERE dk.id_konsultasi = ?
");
$stmtDetail->execute([$id_konsultasi]);
$details = $stmtDetail->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div style="max-width: 800px; margin: 3rem auto; padding: 0 2rem;" class="reveal">
    <div style="background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h2 style="color: var(--primary-color); margin-bottom: 1.5rem;">Form Hasil Deteksi Dini</h2>
        
        <table style="width: 100%; margin-bottom: 1.5rem; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0; font-weight: 600; width: 35%;">Kemungkinan Kondisi</td>
                <td style="padding: 8px 0;">: <?= htmlspecialchars($hasil['interpretasi']); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: 600;">Nilai CF Simulasi</td>
                <td style="padding: 8px 0; font-weight: bold; color: var(--primary-color);">: <?= number_format($hasil['hasil_cf'] * 100, 2); ?>%</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; font-weight: 600;" valign="top">Gejala yang Dipilih</td>
                <td style="padding: 8px 0;">: 
                    <ul style="margin-left: 1.2rem; margin-top: 5px;">
                        <?php foreach ($details as $d): ?>
                            <li><?= htmlspecialchars($d['nama_gejala']); ?> (Keyakinan: <?= $d['cf_user']; ?>)</li>
                        <?php endforeach; ?>
                    </ul>
                </td>
            </tr>
        </table>

        <div style="background: #f0f9ff; border-left: 4px solid var(--primary-color); padding: 1rem; border-radius: 4px; margin-bottom: 1.5rem; font-size: 0.95rem;">
            <strong>Disclaimer:</strong> Hasil ini merupakan informasi deteksi dini, bukan diagnosis medis[cite: 1].<br>
            <strong>Saran:</strong> Hindari pemicu dingin dan konsultasikan kepada tenaga kesehatan jika gejala berulang[cite: 1].
        </div>

        <div style="display: flex; gap: 1rem;">
            <a href="konsultasi.php" class="btn-primary" style="text-align: center; text-decoration: none;">Konsultasi Ulang</a>
            <a href="history.php" style="background: #e2e8f0; color: var(--text-main); padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600;">Lihat Riwayat</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>