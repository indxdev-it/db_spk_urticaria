<?php 
require_once 'config/database.php';
include 'includes/header.php'; 
?>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-content reveal">
        <h1>Deteksi Dini Alergi Kulit Suhu Dingin (Cold Urticaria)</h1>
        <p>Kenali tingkat keyakinan gejala bentol, kemerahan, dan gatal setelah terpapar suhu dingin menggunakan metode <strong>Certainty Factor</strong> secara cepat dan terstruktur.</p>
        <a href="konsultasi.php" class="btn-primary">Mulai Konsultasi Sekarang</a>
    </div>
    <!-- Keterangan: Tempat Gambar Hero / Banner Utama diletakkan -->
    <div class="hero-image reveal">
        <img src="assets/img/hero-bg.png" alt="Ilustrasi Konsultasi Medis" onerror="this.src='https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=500&q=80'">
    </div>
</section>

<!-- SECTION RUMUS & INFORMASI -->
<section style="max-width: 1200px; margin: 4rem auto; padding: 0 2rem;" class="reveal">
    <div style="background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
        <h2 style="margin-bottom: 1rem; color: var(--text-main);">Rumus & Metode Perhitungan</h2>
        <p style="margin-bottom: 1rem; color: var(--text-muted);">Sistem ini menggunakan metode <strong>Certainty Factor (CF)</strong> untuk mengukur tingkat kepastian dari gejala yang dipilih pengguna dibandingkan dengan bobot pakar:</p>
        <div style="background: var(--bg-light); padding: 1rem; border-left: 4px solid var(--primary-color); font-family: monospace; margin-bottom: 1.5rem;">
            CF(E, H) = CF(Pakar) &times; CF(User)
        </div>
        <p style="color: var(--text-muted); font-size: 0.95rem;">
            <em>Disclaimer:</em> Hasil dari sistem pakar ini merupakan informasi deteksi dini dan referensi awal, bukan pengganti diagnosis medis profesional dari dokter spesialis kulit[cite: 1].
        </p>
    </div>
</section>

<?php include 'includes/footer.php'; ?>