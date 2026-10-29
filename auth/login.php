<?php
/**
 * File: auth/login.php
 * Keterangan: Form login pengguna/admin sistem.
 */
session_start();
require_once '../config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    // Jika user belum ada di database, buatkan dummy user otomatis untuk kemudahan testing
    if (!$user && $username == 'admin') {
        $hashed = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->prepare("INSERT INTO users (nama, username, email, password, role) VALUES ('Administrator', 'admin', 'admin@mail.com', ?, 'admin')")->execute([$hashed]);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
    }

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Pakar Cold Urticaria</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background: var(--bg-light);">
    <div style="background: white; padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); width: 100%; max-width: 400px;">
        <h2 style="margin-bottom: 1.5rem; color: var(--text-main); text-align: center;">Login Sistem</h2>
        <?php if($error): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 6px; margin-bottom: 1rem; font-size: 0.9rem;"><?= $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.9rem;">Username</label>
                <input type="text" name="username" required placeholder="Contoh: admin" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 5px; font-weight: 600; font-size: 0.9rem;">Password</label>
                <input type="password" name="password" required placeholder="Contoh: admin123" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px;">
            </div>
            <button type="submit" class="btn-primary" style="width: 100%; padding: 10px;">Login</button>
        </form>
        <p style="text-align: center; margin-top: 1rem; font-size: 0.85rem; color: var(--text-muted);">Default admin: username <strong>admin</strong>, password <strong>admin123</strong></p>
    </div>
</body>
</html>