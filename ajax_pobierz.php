<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit;
}

$nadawca = $_SESSION['user_id'];
$odbiorca = $_GET['odbiorca_id'] ?? null;
$ogloszenie_id = $_GET['ogloszenie_id'] ?? null;

if ($odbiorca && $ogloszenie_id) {
    $stmt = $pdo->prepare("SELECT * FROM wiadomosci WHERE ogloszenie_id = ? AND ((nadawca_id = ? AND odbiorca_id = ?) OR (nadawca_id = ? AND odbiorca_id = ?)) ORDER BY czas ASC");
    $stmt->execute([$ogloszenie_id, $nadawca, $odbiorca, $odbiorca, $nadawca]);
    $wiadomosci = $stmt->fetchAll();
    echo json_encode($wiadomosci);
    exit;
}

http_response_code(400);
