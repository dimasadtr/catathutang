<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Pastikan tidak ada output sebelum header
header("Location: ../../index.php");
exit;
?>
