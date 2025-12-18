<?php
require_once 'auth.php';
require_once __DIR__ . '/../env.php';

$pdo = new PDO(
    "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
    $db_user,
    $db_pass
);

$id = $_GET['id'] ?? null;

$personagem = [
    'nome' => '',
    'origem' => '',
    'nivel' => 1,
    'historia' => ''
];

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM personagens_rpg WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $personagem = $stmt->fetch() ?: $personagem;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($id) {
        $sql = "UPDATE personagens_rpg SET nome=?, origem=?, nivel=?, historia=? WHERE id=?";
        $pdo->prepare($sql)->execute([
            $_POST['nome'], $_POST['origem'], $_POST['nivel'], $_POST['historia'], $id
        ]);
    } else {
        $sql = "INSERT INTO personagens_rpg (nome, origem, nivel, historia)
                VALUES (?, ?, ?, ?)";
        $pdo->prepare($sql)->execute([
            $_POST['nome'], $_POST['origem'], $_POST['nivel'], $_POST['historia']
        ]);
    }

    header('Location: pers_listar.php');
    exit;
}
?>

<h2><?= $id ? 'Editar' : 'Novo' ?> Personagem</h2>

<form method="post">
    <input name="nome" placeholder="Nome" value="<?= htmlspecialchars($personagem['nome']) ?>"><br><br>
    <input name="origem" placeholder="Origem" value="<?= htmlspecialchars($personagem['origem']) ?>"><br><br>
    <input name="nivel" type="number" value="<?= $personagem['nivel'] ?>"><br><br>
    <textarea name="historia" placeholder="História"><?= htmlspecialchars($personagem['historia']) ?></textarea><br><br>
    <button type="submit">Salvar</button>
</form>
