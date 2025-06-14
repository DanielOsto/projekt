<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    if ($stmt->execute([$email, $password])) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Rejestracja nieudana.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Rejestracja</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="lista.php" class="logo">Projekt</a>
	<?php include 'header.php'; ?>
</header>
<main>
    <h2>Zarejestruj się</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <p>Email: <input type="email" name="email" required></p>
        <p>Hasło: <input type="password" name="password" required></p>
        <button type="submit">Zarejestruj</button>
    </form>
</main>
</body>
</html>
