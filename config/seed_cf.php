<?php
/**
 * File: config/seed_cf.php
 * Keterangan: Mengisi data aturan (rules) dan bobot CF Pakar ke database.
 */
require_once 'database.php';

// Cek apakah data aturan sudah ada, jika belum insert data awal
$stmt = $pdo->query("SELECT COUNT(*) FROM aturan");
if ($stmt->fetchColumn() == 0) {
    // 1. Buat Aturan Utama untuk Kondisi PN01 (Cold Urticaria)
    $pdo->exec("INSERT INTO aturan (kode_aturan, id_kondisi, operator, keterangan) VALUES 
        ('R01', 1, 'AND', 'Aturan kombinasi gejala utama bentol, kemerahan, dan gatal')");
    
    $id_aturan = $pdo->lastInsertId();

    // 2. Masukkan Bobot CF Pakar untuk beberapa gejala utama
    // Ambil id_gejala berdasarkan kode
    $gejalaList = [
        'GP01' => 0.80, // Bentol
        'GP02' => 0.60, // Kemerahan
        'GP03' => 1.00, // Gatal
        'GP17' => 0.75, // Bentol perubahan suhu
        'GP18' => 0.70  // Kemerahan perubahan suhu
    ];

    foreach ($gejalaList as $kode => $cf_pakar) {
        $stmtG = $pdo->prepare("SELECT id_gejala FROM gejala WHERE kode_gejala = ?");
        $stmtG->execute([$kode]);
        $g = $stmtG->fetch();
        
        if ($g) {
            $pdo->prepare("INSERT INTO nilai_cf (id_aturan, id_gejala, cf_pakar, status_validasi) VALUES (?, ?, ?, 'Tervalidasi')")
                ->execute([$id_aturan, $g['id_gejala'], $cf_pakar]);
        }
    }
    echo "Data bobot CF Pakar berhasil di-seed!";
}
?>