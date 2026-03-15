<?php
include "db.php";
include "auth.php"; // Oturum kontrolü

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$post_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

try {
    // 1. Önce kullanıcının bu gönderiyi beğenip beğenmediğini kontrol et
    $checkSql = "SELECT * FROM likes WHERE user_id = :user_id AND post_id = :post_id";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([':user_id' => $user_id, ':post_id' => $post_id]);

    if ($checkStmt->rowCount() > 0) {
        // Eğer Beğenmişse: Beğeniyi Sil 
        $sql = "DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id";
    } else {
        // Eğer Beğenmemişse: Beğeniyi Ekle 
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $user_id, ':post_id' => $post_id]);

    // Detay sayfasına geri yönlendir
    header("Location: post_detail.php?id=$post_id");
    exit();

} catch (PDOException $e) {
    echo "Beğenme işlemi hatası: " . $e->getMessage();
}
?>