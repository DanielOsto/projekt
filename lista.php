<?php
require 'db.php';

$query = $pdo->query("SELECT o.*, u.email FROM ogloszenia o JOIN users u ON o.user_id = u.id WHERE o.kupione = 0 ORDER BY o.id DESC");
$ogloszenia = $query->fetchAll();
$kategoria = $_GET['kategoria'] ?? '';

if ($kategoria && in_array($kategoria, ['elektronika','motoryzacja','sport','inne'])) {
    $stmt = $pdo->prepare("SELECT o.*, u.email FROM ogloszenia o JOIN users u ON o.user_id = u.id WHERE o.kategoria = ? AND o.kupione = 0 ORDER BY o.id DESC");
    $stmt->execute([$kategoria]);
    $ogloszenia = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("SELECT o.*, u.email FROM ogloszenia o JOIN users u ON o.user_id = u.id WHERE o.kupione = 0 ORDER BY o.id DESC");
    $ogloszenia = $stmt->fetchAll();
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Lista ogłoszeń</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
	<a href="lista.php" class="logo">Projekt</a>
	<form method="get" style="margin-bottom: 20px;">
    <label for="kategoria">Filtruj po kategorii:</label>
		<select name="kategoria" id="kategoria" onchange="this.form.submit()">
        <option value="">Wszystkie</option>
        <option value="elektronika" <?= (isset($_GET['kategoria']) && $_GET['kategoria'] == 'elektronika') ? 'selected' : '' ?>>Elektronika</option>
        <option value="motoryzacja" <?= (isset($_GET['kategoria']) && $_GET['kategoria'] == 'motoryzacja') ? 'selected' : '' ?>>Motoryzacja</option>
        <option value="sport" <?= (isset($_GET['kategoria']) && $_GET['kategoria'] == 'sport') ? 'selected' : '' ?>>Sport</option>
        <option value="inne" <?= (isset($_GET['kategoria']) && $_GET['kategoria'] == 'inne') ? 'selected' : '' ?>>Inne</option>
    </select>
	</form>
    <?php include 'header.php'; ?>
	
</header> 
<main>

    <?php foreach ($ogloszenia as $ogloszenie): ?>
        <div class="ogloszenie">
            <img src="<?= htmlspecialchars($ogloszenie['zdjecie']) ?>" alt="Miniatura" width="200">
            <div class="ogloszenie-info">
    <h2>
        <a href="ogloszenie.php?id=<?= $ogloszenie['id'] ?>">
            <?= htmlspecialchars($ogloszenie['tytul']) ?>
        </a>
    </h2>
    <p class="cena"><?= number_format($ogloszenie['cena'], 2) ?> zł</p>
	<p class="kategoria">Kategoria: <?= htmlspecialchars($ogloszenie['kategoria']) ?></p>

    <p class="email">Dodane przez: <?= htmlspecialchars($ogloszenie['email']) ?></p>



    <form action="platnosc.php" method="post" style="margin-top: 10px;">
        <input type="hidden" name="ogloszenie_id" value="<?= $ogloszenie['id'] ?>">
        <button type="submit">Kup teraz</button>
    </form>
</div>

        </div>
    <?php endforeach; ?>
</main>
</body>
</html>
