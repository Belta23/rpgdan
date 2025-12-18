<?php
require_once 'auth.php';
require_once __DIR__ . '/../env.php';

$pdo = new PDO(
    "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
    $db_user,
    $db_pass
);

$personagens = $pdo->query("SELECT id, nome, origem, nivel FROM personagens_rpg ORDER BY id")->fetchAll();
?>

<h2>Personagens</h2>

<a href="pers_form.php">➕ Novo Personagem</a>

<table border="1" cellpadding="5">
<tr>
    <th>ID</th>
    <th>Nome</th>
    <th>Origem</th>
    <th>Nível</th>
    <th>Ações</th>
</tr>

<?php foreach ($personagens as $p): ?>
<tr>
    <td><?= $p['id'] ?></td>
    <td><?= htmlspecialchars($p['nome']) ?></td>
    <td><?= htmlspecialchars($p['origem']) ?></td>
    <td><?= $p['nivel'] ?></td>
    <td>
        <a href="pers_form.php?id=<?= $p['id'] ?>">✏️ Editar</a>
        <a href="pers_excluir.php?id=<?= $p['id'] ?>" onclick="return confirm('Excluir?')">🗑️ Excluir</a>
    </td>
</tr>
<?php endforeach; ?>
</table>
