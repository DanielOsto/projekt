<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Zaloguj się";
    exit;
}

$nadawca = $_SESSION['user_id'];
$odbiorca = $_GET['odbiorca_id'] ?? null;
$ogloszenie_id = $_GET['ogloszenie_id'] ?? null;

if (!$odbiorca || !$ogloszenie_id) {
    echo "Brak danych.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Czat</title>
    <link rel="stylesheet" href="style.css">
    <style>
        #chat-box { border: 1px solid #aaa; padding: 10px; height: 300px; overflow-y: auto; }
        #chat-box p { margin: 0; }
    </style>
</head>
<body>
<header>
    <a href="lista.php" class="logo">Projekt</a>
	<?php include 'header.php'; ?>
</header>
<main>
    <h2>Czat</h2>
    <div id="chat-box"></div>
    <form id="chat-form">
        <input type="hidden" name="odbiorca_id" value="<?= htmlspecialchars($odbiorca) ?>">
        <input type="hidden" name="ogloszenie_id" value="<?= htmlspecialchars($ogloszenie_id) ?>">
        <input type="text" name="tresc" id="tresc" placeholder="Napisz wiadomość..." required>
        <button type="submit">Wyślij</button>
    </form>
</main>

<script>
const form = document.getElementById('chat-form');
const chatBox = document.getElementById('chat-box');
const odbiorca = form.odbiorca_id.value;
const ogloszenie = form.ogloszenie_id.value;

function fetchMessages() {
    fetch(`ajax_pobierz.php?ogloszenie_id=${ogloszenie}&odbiorca_id=${odbiorca}`)
        .then(res => res.json())
        .then(data => {
            chatBox.innerHTML = '';
            data.forEach(msg => {
                const who = msg.nadawca_id == <?= $_SESSION['user_id'] ?> ? 'Ty' : 'Użytkownik';
                chatBox.innerHTML += `<p><strong>${who}:</strong> ${escapeHtml(msg.tresc)} <small>(${msg.czas})</small></p>`;
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

form.addEventListener('submit', e => {
    e.preventDefault();
    const formData = new FormData(form);
    fetch('ajax_czat.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        form.tresc.value = '';
        fetchMessages();
    });
});

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;");
}

setInterval(fetchMessages, 3000);
fetchMessages();
</script>
</body>
</html>
