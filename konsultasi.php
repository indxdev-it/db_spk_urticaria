<?php

/**
 * File: konsultasi.php
 * Keterangan: Halaman form konsultasi gejala sistem pakar Cold Urticaria.
 * Perbaikan: Mengubah key array skala_keyakinan menjadi string untuk menghindari Deprecated Warning di PHP terbaru.
 */
session_start();
require_once 'config/database.php';

// Ambil semua data gejala dari database diurutkan berdasarkan kode gejala
$stmt = $pdo->query("SELECT * FROM gejala ORDER BY kode_gejala ASC");
$gejala_list = $stmt->fetchAll();

// Skala keyakinan pengguna (Key diubah menjadi string untuk menghindari deprecation warning float to int)
$skala_keyakinan = [
    '0.00' => 'Tidak ada',
    '0.20' => 'Tidak yakin',
    '0.40' => 'Kurang yakin',
    '0.60' => 'Cukup yakin',
    '0.80' => 'Yakin',
    '1.00' => 'Sangat yakin'
];
?>

<?php include 'includes/header.php'; ?>

<!-- Keterangan: Bagian Hero / Header Halaman Konsultasi -->
<div style="max-width: 900px; margin: 3rem auto; padding: 0 2rem;" class="reveal">
    <div style="background: white; padding: 2.5rem; border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05), 0 8px 10px -6px rgba(0,0,0,0.05);">

        <div style="margin-bottom: 2rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1.5rem;">
            <span style="background: #e0f2fe; color: var(--primary-color); padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600;">Sesi Konsultasi Interaktif</span>
            <h2 style="color: var(--text-main); margin-top: 0.75rem; font-size: 1.8rem;">Deteksi Dini Cold Urticaria</h2>
            <p style="color: var(--text-muted); margin-top: 0.5rem; font-size: 0.95rem;">
                Silakan tentukan tingkat keyakinan Anda terhadap gejala-gejala berikut setelah terpapar suhu dingin. Data ini akan diolah menggunakan metode <em>Certainty Factor</em>.
            </p>
        </div>

        <!-- Keterangan: Form utama konsultasi yang mengirim data ke proses_konsultasi.php -->
        <form action="proses_konsultasi.php" method="POST" id="formKonsultasi">

            <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2.5rem;">
                <?php foreach ($gejala_list as $index => $row): ?>
                    <!-- Keterangan: Item Kartu Gejala -->
                    <div class="reveal" style="background: var(--bg-light); border: 1px solid #e2e8f0; padding: 1.25rem 1.5rem; border-radius: 12px; transition: var(--transition);">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap;">
                            <div style="flex: 1; min-width: 280px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                    <span style="font-weight: 700; color: var(--primary-color); background: #e0f2fe; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem;"><?= htmlspecialchars($row['kode_gejala']); ?></span>
                                    <span style="font-size: 0.8rem; color: var(--text-muted); font-weight: 500;">Status: <?= htmlspecialchars($row['status']); ?></span>
                                </div>
                                <label style="font-weight: 600; color: var(--text-main); font-size: 1rem; cursor: pointer;">
                                    <?= htmlspecialchars($row['nama_gejala']); ?>
                                </label>
                            </div>

                            <!-- Keterangan: Dropdown / Pilihan Tingkat Keyakinan User -->
                            <div style="width: 240px;">
                                <select name="gejala[<?= $row['id_gejala']; ?>]" style="..." onchange="this.style.borderColor='var(--primary-color)'">
                                    <?php foreach ($skala_keyakinan as $val => $label): ?>
                                        <option value="<?= $val; ?>"><?= $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Keterangan: Tombol Aksi Form & Trigger Pop-up Konfirmasi -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end; align-items: center; border-top: 2px solid #f1f5f9; padding-top: 1.5rem;">
                <button type="button" id="btnReset" style="background: #e2e8f0; color: var(--text-main); border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: var(--transition);">Reset Pilihan</button>
                <button type="button" id="btnProses" class="btn-primary" style="padding: 0.75rem 2rem;">Proses Deteksi Dini</button>
            </div>
        </form>
    </div>
</div>

<!-- Keterangan: Elemen Modal Pop-up Konfirmasi Interaktif -->
<div id="modalKonfirmasi" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 2000; justify-content: center; align-items: center; backdrop-filter: blur(4px);">
    <div style="background: white; padding: 2rem; border-radius: 16px; max-width: 400px; width: 90%; text-align: center; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); animation: popUpScale 0.3s ease;">
        <div style="width: 50px; height: 50px; background: #e0f2fe; color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto; font-size: 1.5rem; font-weight: bold;">?</div>
        <h3 style="color: var(--text-main); margin-bottom: 0.5rem;">Mulai Analisis?</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Pastikan tingkat keyakinan gejala yang Anda pilih sudah sesuai dengan kondisi nyata yang dialami.</p>
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button type="button" id="btnBatalModal" style="background: #e2e8f0; color: var(--text-main); border: none; padding: 0.6rem 1.2rem; border-radius: 8px; font-weight: 600; cursor: pointer;">Periksa Lagi</button>
            <button type="button" id="btnYaModal" class="btn-primary" style="padding: 0.6rem 1.5rem;">Ya, Proses</button>
        </div>
    </div>
</div>

<!-- Keterangan: Tambahan Styling Animasi Pop-up CSS di halaman ini -->
<style>
    @keyframes popUpScale {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<!-- Keterangan: Script Javascript Lokal untuk Interaksi Modal Pop-up & Reset Form -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btnProses = document.getElementById("btnProses");
        const modalKonfirmasi = document.getElementById("modalKonfirmasi");
        const btnBatalModal = document.getElementById("btnBatalModal");
        const btnYaModal = document.getElementById("btnYaModal");
        const formKonsultasi = document.getElementById("formKonsultasi");
        const btnReset = document.getElementById("btnReset");

        // Munculkan modal pop-up ketika tombol proses diklik
        btnProses.addEventListener("click", function() {
            modalKonfirmasi.style.display = "flex";
        });

        // Tutup modal jika tombol batal diklik
        btnBatalModal.addEventListener("click", function() {
            modalKonfirmasi.style.display = "none";
        });

        // Submit form jika user menekan "Ya, Proses" di dalam modal
        btnYaModal.addEventListener("click", function() {
            formKonsultasi.submit();
        });

        // Fitur reset pilihan dropdown
        btnReset.addEventListener("click", function() {
            const selects = formKonsultasi.querySelectorAll("select");
            selects.forEach(select => select.value = "0.00");
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>

<?php include 'includes/footer.php'; ?>