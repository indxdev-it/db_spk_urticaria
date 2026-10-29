<?php
/**
 * File: auth/logout.php
 * Keterangan: Mengakhiri sesi login.
 */
session_start();
session_destroy();
header("Location: ../index.php");
exit;
?>