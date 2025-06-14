<?php
session_start();
require 'db.php';



$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT 
        w.ogloszenie_id,
        o.tytul,
        o.user_id as ogloszeniodawca,
        CASE 
            WHEN w.nadawca_id = :user THEN w.odbiorca_id 
            ELSE w.nadawca_id 
        END as rozmowca
    FROM wiadomosci w
    JOIN ogloszenia o ON o.id = w.ogloszenie_id
    WHERE w.nadawca_id = :user OR w.odbiorca_id = :user
    GROUP BY w.ogloszenie_id, rozmowca
    ORDER BY MAX(w.czas) DESC
");
$stmt->execute(['user' => $user_id]);
$czaty = $stmt->fetchAll();
?>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista ogłoszeń</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="lista.php" class="logo">Projekt</a>
    <div class="auth">
		<?php include 'header.php'; ?>
    </div>
</header> 
<main>
<h2>Twoje czaty</h2>
<ul>
<?php foreach ($czaty as $czat): ?>
    <li>
        Ogłoszenie: <strong><?= htmlspecialchars($czat['tytul']) ?></strong><br>
        <a href="czat.php?ogloszenie_id=<?= $czat['ogloszenie_id'] ?>&odbiorca_id=<?= $czat['rozmowca'] ?>">
            Otwórz czat 💬
        </a>
    </li>
<?php endforeach; ?>
</ul>
</main>
</body>
</html>