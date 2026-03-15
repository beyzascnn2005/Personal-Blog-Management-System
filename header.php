<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <title>Blog Uygulaması</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <nav>
          <a href="index.php">Ana Sayfa</a>
          <a href="users.php">Kullanıcılar</a> |
          <a href="top_users.php">Top 10 Aktif Kullanıcı</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="create_post.php">Yeni Gönderi</a> |
        <a href="logout.php">Çıkış</a>
    <?php else: ?>
        <a href="login.php">Giriş Yap</a> |
        <a href="register.php">Kayıt Ol</a>
    <?php endif; ?>
    </nav>
