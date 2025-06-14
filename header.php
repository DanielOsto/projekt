<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';
?>

<link rel="stylesheet" href="style.css">
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('dark-mode') === 'true') {
        document.body.classList.add('dark');
    }

    const toggle = document.getElementById('toggle-dark');
    if (toggle) {
        toggle.addEventListener('click', () => {
            document.body.classList.toggle('dark');
            localStorage.setItem('dark-mode', document.body.classList.contains('dark'));
        });
    }
});
</script>

<!-- Dodany nagłówek z logo po lewej stronie -->
<div class="top-bar">
    <div class="auth-links">
        <?php if (isset($_SESSION['user_id'])): ?>
            Zalogowano jako <?= htmlspecialchars($_SESSION['user_email'] ?? 'Nieznany') ?> |
            <a href="czaty.php" title="Twoje czaty">💬</a>
            <a href="dodaj.php">Dodaj ogłoszenie</a>
            <a href="logout.php">Wyloguj</a>
        <?php else: ?>
            <a href="login.php">Zaloguj</a> |
            <a href="register.php">Zarejestruj się</a>
        <?php endif; ?>
        <button id="toggle-dark">🌓 Zmień motyw</button>
    </div>
</div>
