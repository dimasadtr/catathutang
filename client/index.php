<?php
session_start();
if (isset($_SESSION['user'])) {
	header("Location: dashboard.php");
	exit;
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="indexlogin.css">
</head>

<body>
<div class="container" id="container">

    <div class="form-container sign-in-container">
        <form action="user/login/userlogin.php" method="POST">
            <h1>Masuk</h1>

            <input type="username" name="username" placeholder="username" required />
            <input type="password" name="password" placeholder="Password" required />

            <button type="submit">Sign In</button>

            <?php if (isset($_GET['error'])): ?>
                <p class="text-danger mt-2"><?= htmlspecialchars($_GET['error']) ?></p>
            <?php endif; ?>

        </form>
    </div>

    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-right">
                <h1>Selamat Datang!</h1>
                <p>Sistem Pencatatan Hutang Toko Anugrah</p>
            </div>
        </div>
    </div>

</div>

</body>
</html>
