<?php require_once 'auth.php'; ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin • Crônicas da Mesa</title>
</head>
<body>

<h1>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>

<ul>
    <li><a href="personagens_listar.php">Gerenciar Personagens / NPCs</a></li>
    <li><a href="logout.php">Sair</a></li>
</ul>

</body>
</html>
