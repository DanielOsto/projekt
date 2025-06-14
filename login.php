<?php
session_start();
require 'db.php';
 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
		$_SESSION['user_email'] = $user['email'];
        header("Location: lista.php");
        exit;
    } else {
        $error = "Nieprawidłowe dane logowania.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="lista.php" class="logo">Projekt</a>
	<?php include 'header.php'; ?>
</header>
<main>
    <h2>Zaloguj się</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <p>Email: <input type="email" name="email" required></p>
        <p>Hasło: <input type="password" name="password" required></p>
        <button type="submit">Zaloguj</button>
    </form>
</main>
</body>
</html>
