<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ogloszenie_id'])) {
    $ogloszenie_id = (int)$_POST['ogloszenie_id'];
} else {
    header('Location: lista.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Symulacja płatności</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="lista.php" class="logo">Projekt</a>
	 <?php include 'header.php'; ?>
</header>
<main>
    <h2>Wybierz metodę płatności</h2>
    <form action="finalizuj.php" method="post">
        <input type="hidden" name="ogloszenie_id" value="<?= $ogloszenie_id ?>">

        <label><input type="radio" name="metoda" value="karta" required> Karta</label><br>
        <label><input type="radio" name="metoda" value="blik"> BLIK</label><br>
        <label><input type="radio" name="metoda" value="przelew"> Przelew</label><br><br>

        <button type="submit">Zapłać</button>
    </form>
</main>
</body>
</html>
