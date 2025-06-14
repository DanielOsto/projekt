<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Nieautoryzowany']);
    exit;
}

$nadawca = $_SESSION['user_id'];
$odbiorca = $_POST['odbiorca_id'] ?? null;
$ogloszenie_id = $_POST['ogloszenie_id'] ?? null;
$tresc = trim($_POST['tresc'] ?? '');

if ($odbiorca && $ogloszenie_id && $tresc !== '') {
    $stmt = $pdo->prepare("INSERT INTO wiadomosci (nadawca_id, odbiorca_id, ogloszenie_id, tresc) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nadawca, $odbiorca, $ogloszenie_id, $tresc]);
    echo json_encode(['status' => 'ok']);
    exit;
}

http_response_code(400);
echo json_encode(['error' => 'Błędne dane']);
