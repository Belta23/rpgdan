<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Área Administrativa</title>
</head>
<body>

<h2>Área Administrativa</h2>
<p>Bem-vindo, <strong><?= $_SESSION['usuario'] ?></strong></p>

<ul>
    <li><a href="personagens.php">📜 Gerenciar Personagens (Players + NPCs)</a></li>
    <li><a href="../index.php">🌍 Voltar ao site</a></li>
    <li><a href="logout.php">🚪 Sair</a></li>
</ul>

</body>
</html>
