<?php
/**
 * File: proses_konsultasi.php
 * Keterangan: Logika backend perhitungan Certainty Factor (CF).
 */
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $gejala_input = $_POST['gejala'] ?? [];
    
    // Filter hanya gejala yang dipilih pengguna dengan CF user > 0
    $evidence_list = [];
    foreach ($gejala_input as $id_gejala => $cf_user) {
        if ($cf_user > 0) {
            // Ambil cf_pakar dari tabel nilai_cf (jika belum ada di nilai_cf, beri default 0.60 atau ambil relasi aturan)
            $stmt = $pdo->prepare("SELECT cf_pakar FROM nilai_cf WHERE id_gejala = ? LIMIT 1");
            $stmt->execute([$id_gejala]);
            $cf_pakar_row = $stmt->fetch();
            
            // Default bobot pakar jika belum diset secara spesifik di tabel nilai_cf
            $cf_pakar = $cf_pakar_row ? floatval($cf_pakar_row['cf_pakar']) : 0.60; 
            
            // Rumus: CF(E,H) = CF Pakar * CF User
            $cf_evidence = $cf_pakar * floatval($cf_user);
            
            $evidence_list[] = [
                'id_gejala' => $id_gejala,
                'cf_user' => floatval($cf_user),
                'cf_evidence' => $cf_evidence
            ];
        }
    }

    if (empty($evidence_list)) {
        echo "<script>alert('Pilih minimal satu gejala dengan tingkat keyakinan > Tidak!'); window.location='konsultasi.php';</script>";
        exit;
    }

    // Algoritma Kombinasi Certainty Factor (CF old + CF new * (1 - CF old))
    $cf_old = 0;
    $is_first = true;
    foreach ($evidence_list as $ev) {
        if ($is_first) {
            $cf_old = $ev['cf_evidence'];
            $is_first = false;
        } else {
            $cf_old = $cf_old + $ev['cf_evidence'] * (1 - $cf_old);
        }
    }

    $hasil_persen = $cf_old * 100;
    $interpretasi = "Cold Urticaria (Alergi Kulit Suhu Dingin)";
    $catatan = "Hasil deteksi dini berdasarkan kombinasi gejala dan metode Certainty Factor. Bukan diagnosis medis definitif.";

    // Simpan ke tabel konsultasi (Simulasikan id_user = 1 jika belum login sistem session user)
    $id_user = $_SESSION['user_id'] ?? 1; 

    $stmtInsert = $pdo->prepare("INSERT INTO konsultasi (id_user, hasil_cf, interpretasi, catatan) VALUES (?, ?, ?, ?)");
    $stmtInsert->execute([$id_user, $cf_old, $interpretasi, $catatan]);
    $id_konsultasi = $pdo->lastInsertId();

    // Simpan detail konsultasi
    foreach ($evidence_list as $ev) {
        $stmtDetail = $pdo->prepare("INSERT INTO detail_konsultasi (id_konsultasi, id_gejala, cf_user, cf_evidence) VALUES (?, ?, ?, ?)");
        $stmtDetail->execute([$id_konsultasi, $ev['id_gejala'], $ev['cf_user'], $ev['cf_evidence']]);
    }

    // Redirect ke halaman hasil
    header("Location: hasil.php?id=" . $id_konsultasi);
    exit;
}
?>