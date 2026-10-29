<?php
/**
 * File: history.php
 * Keterangan: Halaman riwayat hasil konsultasi pengguna.
 */
session_start();
require_once 'config/database.php';

// Batasi jika belum login (simulasi id_user = 1 jika testing)
$id_user = $_SESSION['user_id'] ?? 1;

$stmt = $pdo->prepare("SELECT * FROM konsultasi WHERE id_user = ? ORDER BY tanggal DESC");
$stmt->execute([$id_user]);
$riwayat = $stmt->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div style="max-width: 1000px; margin: 3rem auto; padding: 0 2rem;" class="reveal">
    <div style="background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h2 style="color: var(--text-main); margin-bottom: 1rem;">Riwayat Konsultasi</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">Daftar hasil deteksi dini yang pernah Anda lakukan sebelumnya[cite: 1].</p>

        <?php if (empty($riwayat)): ?>
            <p style="color: var(--text-muted); text-align: center; padding: 2rem;">Belum ada riwayat konsultasi.</p>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 10px;">Tanggal</th>
                            <th style="padding: 10px;">Hasil Deteksi</th>
                            <th style="padding: 10px;">Nilai CF</th>
                            <th style="padding: 10px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($riwayat as $row): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 12px 10px;"><?= $row['tanggal']; ?></td>
                            <td style="padding: 12px 10px; font-weight: 600;"><?= htmlspecialchars($row['interpretasi']); ?></td>
                            <td style="padding: 12px 10px; color: var(--primary-color); font-weight: bold;"><?= number_format($row['hasil_cf'] * 100, 2); ?>%</td>
                            <td style="padding: 12px 10px;">
                                <a href="hasil.php?id=<?= $row['id_konsultasi']; ?>" style="background: var(--primary-color); color: #fff; padding: 6px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">Lihat Detail</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>