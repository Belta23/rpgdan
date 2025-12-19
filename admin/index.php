<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Área Administrativa</title>
<style>
body {
    background:#0f0f14;
    color:#e6e6eb;
    font-family:Arial;
    padding:40px;
}
h1 {
    color:#d4af37;
}
a {
    display:inline-block;
    margin:10px 0;
    padding:10px 16px;
    background:#1a1a24;
    color:#d4af37;
    text-decoration:none;
    border-radius:8px;
    border:1px solid rgba(212,175,55,0.2);
}
a:hover {
    background:#242436;
}
</style>
</head>

<body>

<h1>Área Administrativa – NPCs & Players</h1>

<p>Bem-vindo, <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong></p>

<hr>

<a href="personagens.php">🧙 Gerenciar Personagens (Players & NPCs)</a><br>
<a href="logout.php">🚪 Sair</a>

</body>
</html>
