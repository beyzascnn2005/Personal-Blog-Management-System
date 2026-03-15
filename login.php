<?php
include "db.php";
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = md5($_POST["password"]); // Şifre md5 ile şifreleniyor

    try {
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];
            header("Location: index.php");
            exit();
        } else {
            echo "<p style='color:red;'>Geçersiz e-posta veya şifre.</p>";
        }
    } catch (PDOException $e) {
        echo "<p style='color:red;'>Veritabanı hatası: " . $e->getMessage() . "</p>";
    }
}
?>

<form method="POST">
    <h2>Giriş Yap</h2>
    <input type="email" name="email" placeholder="E-posta" required><br>
    <input type="password" name="password" placeholder="Şifre" required><br>
    <button type="submit">Giriş Yap</button>
</form>
<p>Üye değil misiniz? <a href="register.php">Kayıt Ol</a></p>

<?php include 'footer.php'; ?>
