<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pobierz dane z formularza bezpośrednio po przesłaniu
    $tytul = isset($_POST['tytul']) ? trim($_POST['tytul']) : '';
    $cena = isset($_POST['cena']) ? floatval($_POST['cena']) : 0;
    $kategoria = isset($_POST['kategoria']) ? trim($_POST['kategoria']) : '';
    $zdjecie = isset($_FILES['zdjecie']) ? $_FILES['zdjecie'] : null;

    // Walidacja danych
    if ($tytul === '' || $cena <= 0 || $kategoria === '' || !$zdjecie || $zdjecie['error'] !== 0) {
        $errors[] = "Wszystkie pola są wymagane i muszą być poprawne.";
    } else {
        // Obsługa uploadu zdjęcia
        $upload_dir = 'uploads/';
        // Tworzymy unikalną nazwę pliku, żeby uniknąć nadpisania
        $filename = basename($zdjecie['name']);
        $target_file = $upload_dir . uniqid() . '_' . $filename;

        if (move_uploaded_file($zdjecie['tmp_name'], $target_file)) {
            // Wstawianie do bazy - uwzględniamy kategorię i user_id z sesji
            $stmt = $pdo->prepare("INSERT INTO ogloszenia (tytul, cena, zdjecie, user_id, kategoria) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$tytul, $cena, $target_file, $_SESSION['user_id'], $kategoria]);

            // Po udanym dodaniu przekieruj na listę
            header("Location: lista.php");
            exit;
        } else {
            $errors[] = "Błąd podczas przesyłania zdjęcia.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj ogłoszenie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <a href="lista.php" class="logo">Projekt</a>
    <?php include 'header.php'; ?>
</header>
<main>
    <h2>Dodaj ogłoszenie</h2>
    <?php foreach ($errors as $e) echo "<p style='color:red;'>$e</p>"; ?>
    <form method="post" enctype="multipart/form-data">
        <p>Tytuł: <input type="text" name="tytul" required></p>
        <p>Cena: <input type="number" step="0.01" name="cena" required></p>
        <p>Kategoria:
            <select name="kategoria" required>
                <option value="">-- Wybierz kategorię --</option>
                <option value="elektronika">Elektronika</option>
                <option value="motoryzacja">Motoryzacja</option>
                <option value="sport">Sport</option>
                <option value="inne">Inne</option>
            </select>
        </p>
        <p>Zdjęcie: <input type="file" name="zdjecie" accept="image/*" required></p>
        <button type="submit">Dodaj</button>
    </form>
</main>
</body>
</html>
