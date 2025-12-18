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
<title>Painel NPCs</title>
</head>
<body>

<h1>Área Administrativa – NPCs</h1>

<p>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?></p>

<ul>
  <li><a href="npcs.php">Gerenciar NPCs</a></li>
  <li><a href="logout.php">Sair</a></li>
</ul>

</body>
</html>
