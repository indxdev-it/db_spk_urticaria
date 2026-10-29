<?php
/**
 * File: tentang.php
 * Keterangan: Halaman informasi umum mengenai Cold Urticaria, pencegahan, dan penanganan.
 * Gambar/Asset: Tidak ada gambar khusus, menggunakan kartu informasi bersih.
 */
session_start();
include 'includes/header.php';
?>

<div style="max-width: 1000px; margin: 3rem auto; padding: 0 2rem;" class="reveal">
    <div style="background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h2 style="color: var(--text-main); margin-bottom: 1rem;">Tentang Cold Urticaria (Alergi Dingin)</h2>
        <p style="color: var(--text-muted); margin-bottom: 2rem;">
            Cold Urticaria adalah kondisi kulit yang menimbulkan reaksi berupa bentol, kemerahan, atau gatal setelah terpapar suhu dingin[cite: 1]. Sistem pakar ini dirancang untuk memberikan deteksi dini secara terstruktur menggunakan metode <em>Certainty Factor</em>[cite: 1].
        </p>

        <!-- Informasi Penanganan -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
            <div style="background: var(--bg-light); padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary-color);">
                <h3 style="margin-bottom: 0.75rem; color: var(--text-main);">Penanganan Awal</h3>
                <ul style="padding-left: 1.2rem; color: var(--text-muted); font-size: 0.95rem;">
                    <li>Hindari paparan suhu dingin secara langsung[cite: 1].</li>
                    <li>Gunakan pakaian hangat atau proteksi termal[cite: 1].</li>
                    <li>Kompres hangat pada area kulit yang terkena[cite: 1].</li>
                    <li>Konsultasikan kepada tenaga medis untuk penanganan lanjutan[cite: 1].</li>
                </ul>
            </div>

            <div style="background: var(--bg-light); padding: 1.5rem; border-radius: 8px; border-left: 4px solid #38bdf8;">
                <h3 style="margin-bottom: 0.75rem; color: var(--text-main);">Pencegahan Umum</h3>
                <ul style="padding-left: 1.2rem; color: var(--text-muted); font-size: 0.95rem;">
                    <li>Kurangi transisi suhu ekstrem secara mendadak[cite: 1].</li>
                    <li>Gunakan pakaian pelindung saat cuaca dingin[cite: 1].</li>
                    <li>Hindari mandi atau kontak langsung dengan air es/dingin[cite: 1].</li>
                    <li>Catat pola gejala dan pemicu yang mendahului[cite: 1].</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>