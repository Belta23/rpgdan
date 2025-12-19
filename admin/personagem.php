<?php
session_start();
require_once __DIR__ . '/env_admin.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? null;
$personagem = null;

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // EDITAR
    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM personagens_rpg WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $personagem = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$personagem) {
            die('Personagem não encontrado.');
        }
    }

    // SALVAR
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dados = $_POST;

        if ($id) {
            $sql = "UPDATE personagens_rpg SET
                nome=:nome, nivel=:nivel, origem=:origem, vida_max=:vida_max,
                denarios=:denarios, fisico=:fisico, agilidade=:agilidade,
                inteligencia=:inteligencia, carisma=:carisma,
                armas_e_dano=:armas, armadura_desc=:armadura,
                inventario=:inventario, historia=:historia
                WHERE id=:id";
            $dados['id'] = $id;
        } else {
            $sql = "INSERT INTO personagens_rpg
                (nome, nivel, origem, vida_max, denarios, fisico, agilidade,
                inteligencia, carisma, armas_e_dano, armadura_desc, inventario, historia)
                VALUES
                (:nome,:nivel,:origem,:vida_max,:denarios,:fisico,:agilidade,
                :inteligencia,:carisma,:armas,:armadura,:inventario,:historia)";
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nome' => $dados['nome'],
            ':nivel' => $dados['nivel'],
            ':origem' => $dados['origem'],
            ':vida_max' => $dados['vida_max'],
            ':denarios' => $dados['denarios'],
            ':fisico' => $dados['fisico'],
            ':agilidade' => $dados['agilidade'],
            ':inteligencia' => $dados['inteligencia'],
            ':carisma' => $dados['carisma'],
            ':armas' => $dados['armas_e_dano'],
            ':armadura' => $dados['armadura_desc'],
            ':inventario' => $dados['inventario'],
            ':historia' => $dados['historia'],
            ...($id ? [':id' => $id] : [])
        ]);

        header('Location: personagens.php');
        exit;
    }

} catch (Exception $e) {
    die('Erro interno.');
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= $id ? 'Editar' : 'Novo' ?> Personagem</title>
</head>
<body>

<h2><?= $id ? 'Editar' : 'Novo' ?> Personagem</h2>

<form method="post">

<input name="nome" placeholder="Nome" required value="<?= $personagem['nome'] ?? '' ?>"><br><br>
<input name="nivel" placeholder="Nível" value="<?= $personagem['nivel'] ?? '' ?>"><br><br>
<input name="origem" placeholder="Origem" value="<?= $personagem['origem'] ?? '' ?>"><br><br>
<input name="vida_max" placeholder="Vida Máx" value="<?= $personagem['vida_max'] ?? '' ?>"><br><br>
<input name="denarios" placeholder="Denários" value="<?= $personagem['denarios'] ?? '' ?>"><br><br>

<textarea name="armas_e_dano" placeholder="Armas"><?= $personagem['armas_e_dano'] ?? '' ?></textarea><br><br>
<textarea name="armadura_desc" placeholder="Armadura"><?= $personagem['armadura_desc'] ?? '' ?></textarea><br><br>
<textarea name="inventario" placeholder="Inventário"><?= $personagem['inventario'] ?? '' ?></textarea><br><br>
<textarea name="historia" placeholder="História"><?= $personagem['historia'] ?? '' ?></textarea><br><br>

<button type="submit">Salvar</button>

</form>

<p><a href="personagens.php">⬅ Voltar</a></p>

</body>
</html>
