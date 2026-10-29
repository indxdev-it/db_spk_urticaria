<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Cold Urticaria</title>
    <!-- Keterangan: Memuat file CSS utama -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <navbar>
        <div class="nav-container">
            <!-- Keterangan: Gambar Logo website diletakkan di sini -->
            <div class="nav-logo">
                <a href="index.php">
                    <img src="assets/img/logo.png" alt="Logo Cold Urticaria" onerror="this.style.display='none';"> 
                    <span style="font-weight:700; color:var(--primary-color); font-size:1.2rem;">SPK-Urticaria</span>
                </a>
            </div>
            
            <ul class="nav-menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="tentang.php">Tentang</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="history.php">History</a></li>
                    <li><a href="auth/logout.php" style="color: #ef4444;">Logout</a></li>
                <?php else: ?>
                    <li><a href="auth/login.php" class="btn-primary" style="padding: 0.4rem 1rem; color: #fff;">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </navbar>