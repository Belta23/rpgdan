<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../env.php';

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Busca NPCs
    $stmt = $pdo->query("SELECT id, nome, descricao FROM npcs ORDER BY nome");
    $npcs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    die("Erro ao conectar ao banco.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Gerenciar NPCs</title>
</head>
<body>

<h1>Gerenciar NPCs</h1>

<p>
  <a href="npcs_create.php">➕ Novo NPC</a> |
  <a href="dashboard.php">⬅ Voltar</a>
</p>

<table border="1" cellpadding="8">
<tr>
  <th>ID</th>
  <th>Nome</th>
  <th>Descrição</th>
  <th>Ações</th>
</tr>

<?php if (empty($npcs)): ?>
<tr>
  <td colspan="4">Nenhum NPC cadastrado.</td>
</tr>
<?php endif; ?>

<?php foreach ($npcs as $npc): ?>
<tr>
  <td><?= $npc['id'] ?></td>
  <td><?= htmlspecialchars($npc['nome']) ?></td>
  <td><?= nl2br(htmlspecialchars($npc['descricao'])) ?></td>
  <td>
    <a href="npcs_edit.php?id=<?= $npc['id'] ?>">Editar</a> |
    <a href="npcs_delete.php?id=<?= $npc['id'] ?>" onclick="return confirm('Excluir NPC?')">Excluir</a>
  </td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
