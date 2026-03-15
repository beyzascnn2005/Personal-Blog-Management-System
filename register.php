<?php
include "db.php";
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = md5($_POST["password"]); // sadece md5

    // E-posta Benzersizlik Kontrolü
    try {
        $checkSql = "SELECT id FROM users WHERE email = :email";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->execute([':email' => $email]);

        if ($checkStmt->rowCount() > 0) {
            // Eğer bu e-posta ile kayıt varsa, hata mesajı gösterilir ve işlem durur.
            echo "<p style='color:red; text-align:center;'>Bu e-posta adresi zaten kullanılıyor. Lütfen farklı bir mail adresi deneyin.</p>";
            include 'footer.php';
            exit(); 
        }
    } catch (PDOException $e) {
        // Kontrol sırasında bir DB hatası olursa
        echo "Veritabanı kontrol hatası: " . $e->getMessage();
        include 'footer.php';
        exit();
    }
    
    // Benzersizse Kayıt İşlemi Yapılır
    try {
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password
        ]);
        
        // Başarılıysa Giriş sayfasına yönlendir.
        header("Location: login.php");
        exit();

    } catch (PDOException $e) {
        // Eğer UNIQUE kısıtlamasına rağmen buraya düşerse (çok nadir)
        echo "Kayıt hatası: " . $e->getMessage();
    }
}
?>

<h2>Kayıt Ol</h2>
<form action="register.php" method="POST">
    <label for="username">Kullanıcı Adı:</label>
    <input type="text" name="username" required><br>

    <label for="email">E-posta:</label>
    <input type="email" name="email" required><br>

    <label for="password">Şifre:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Kayıt Ol</button>
</form>

<?php include 'footer.php'; ?>