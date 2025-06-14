<?php
session_start();
require 'db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT o.*, u.email FROM ogloszenia o JOIN users u ON o.user_id = u.id WHERE o.id = ?");
$stmt->execute([$id]);
$ogloszenie = $stmt->fetch();

if (!$ogloszenie) {
    echo "Ogłoszenie nie znalezione.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($ogloszenie['tytul']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
	<a href="lista.php" class="logo">Projekt</a>
 <?php include 'header.php'; ?>
</header>
<main>
    <h1><?= htmlspecialchars($ogloszenie['tytul']) ?></h1>
    <img src="<?= htmlspecialchars($ogloszenie['zdjecie']) ?>" alt="Zdjęcie" style="max-width:300px;">
    <p>Cena: <strong><?= number_format($ogloszenie['cena'], 2) ?> zł</strong></p>
	<p class="kategoria">Kategoria: <?= htmlspecialchars($ogloszenie['kategoria']) ?></p>

    <p>Email użytkownika: <?= htmlspecialchars($ogloszenie['email']) ?></p>


    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] !== $ogloszenie['user_id']): ?>
        <form method="get" action="czat.php">
            <input type="hidden" name="odbiorca_id" value="<?= $ogloszenie['user_id'] ?>">
            <input type="hidden" name="ogloszenie_id" value="<?= $ogloszenie['id'] ?>">
            <button>Rozpocznij czat</button>
        </form>

    <?php endif; ?>
	
	   	<form action="platnosc.php" method="post">
			<input type="hidden" name="ogloszenie_id" value="<?= $ogloszenie['id'] ?>">
			<button type="submit">Kup teraz</button>
		</form>
</main>
</body>
</html>