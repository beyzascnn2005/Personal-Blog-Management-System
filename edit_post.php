<?php
//include 'header.php';
include "db.php";
include "auth.php";

$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

try {
    $checkSql = "SELECT * FROM posts WHERE id = :id AND user_id = :user_id";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([
        ':id' => $id,
        ':user_id' => $user_id
    ]);
    $post = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$post) {
        echo "Erişim reddedildi.";
        exit();
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $content = $_POST["content"];

        $updateSql = "UPDATE posts SET title = :title, content = :content WHERE id = :id AND user_id = :user_id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':id' => $id,
            ':user_id' => $user_id
        ]);

        header("Location: index.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>

<div class="container">
    <form method="POST">
        <h2>Gönderiyi Düzenle</h2>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>
        <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
        <button type="submit">Güncelle</button>
    </form>
    <a href="index.php" class="btn-back">← Geri</a>
</div>

<style>

  header h1, header h2 {
    display: none;
  }
</style>

<?php include 'footer.php'; ?>
