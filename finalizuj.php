<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ogloszenie_id'], $_POST['metoda'])) {
    $ogloszenie_id = (int)$_POST['ogloszenie_id'];
    $metoda = $_POST['metoda'];

    // Tu możesz dodać symulację przetwarzania płatności...

    // ukryj ogłoszenie
	$stmt = $pdo->prepare("UPDATE ogloszenia SET kupione = 1 WHERE id = ?");
	$stmt->execute([$ogloszenie_id]);;

    $komunikat = "Płatność metodą „" . htmlspecialchars($metoda) . "” zakończona sukcesem. Jest to tylko atrapa systemu płatności i nie przetwarzam żadnych danych.";
} else {
    header('Location: lista.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Płatność zakończona</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="lista.php" class="logo">Projekt</a>
	 <?php include 'header.php'; ?>
</header>
<main>
    <h2>Dziękujemy za zakup!</h2>
    <p><?= $komunikat ?></p>
    <a href="lista.php">Powrót do listy ogłoszeń</a>
</main>
</body>
</html>
