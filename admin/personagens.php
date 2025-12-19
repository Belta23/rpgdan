<?php
session_start();
require_once __DIR__ . '/../env.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (Exception $e) {
    die('Erro ao conectar no banco.');
}

/* =========================
   AÇÕES CRUD
========================= */

// EXCLUIR
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM personagens_rpg WHERE id = :id");
    $stmt->execute([':id' => $id]);
    header('Location: personagens.php');
    exit;
}

// CRIAR / EDITAR
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'],
        'nivel' => $_POST['nivel'],
        'origem' => $_POST['origem'],
        'vida_max' => $_POST['vida_max'],
        'denarios' => $_POST['denarios'],
        'fisico' => $_POST['fisico'],
        'agilidade' => $_POST['agilidade'],
        'inteligencia' => $_POST['inteligencia'],
        'carisma' => $_POST['carisma'],
        'poder_combate' => $_POST['poder_combate'],
        'poder_pontaria' => $_POST['poder_pontaria'],
        'medicina' => $_POST['medicina'],
        'intuicao' => $_POST['intuicao'],
        'persuadir' => $_POST['persuadir'],
        'armas_e_dano' => $_POST['armas_e_dano'],
        'armadura_desc' => $_POST['armadura_desc'],
        'inventario' => $_POST['inventario'],
        'historia' => $_POST['historia'],
    ];

    if (!empty($_POST['id'])) {
        // EDITAR
        $dados['id'] = $_POST['id'];
        $sql = "UPDATE personagens_rpg SET
            nome=:nome, nivel=:nivel, origem=:origem, vida_max=:vida_max, denarios=:denarios,
            fisico=:fisico, agilidade=:agilidade, inteligencia=:inteligencia, carisma=:carisma,
            poder_combate=:poder_combate, poder_pontaria=:poder_pontaria, medicina=:medicina,
            intuicao=:intuicao, persuadir=:persuadir, armas_e_dano=:armas_e_dano,
            armadura_desc=:armadura_desc, inventario=:inventario, historia=:historia
            WHERE id=:id";
    } else {
        // CRIAR
        $sql = "INSERT INTO personagens_rpg
        (nome,nivel,origem,vida_max,denarios,fisico,agilidade,inteligencia,carisma,
        poder_combate,poder_pontaria,medicina,intuicao,persuadir,
        armas_e_dano,armadura_desc,inventario,historia)
        VALUES
        (:nome,:nivel,:origem,:vida_max,:denarios,:fisico,:agilidade,:inteligencia,:carisma,
        :poder_combate,:poder_pontaria,:medicina,:intuicao,:persuadir,
        :armas_e_dano,:armadura_desc,:inventario,:historia)";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($dados);
    header('Location: personagens.php');
    exit;
}

// EDITAR (buscar dados)
$editar = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM personagens_rpg WHERE id = :id");
    $stmt->execute([':id' => (int)$_GET['edit']]);
    $editar = $stmt->fetch(PDO::FETCH_ASSOC);
}

// LISTA
$lista = $pdo->query("SELECT * FROM personagens_rpg ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Admin - Personagens</title>
<style>
body { background:#111; color:#eee; font-family:Arial; padding:30px; }
table { width:100%; border-collapse:collapse; margin-top:20px; }
th, td { border:1px solid #333; padding:8px; }
th { background:#222; }
a { color:#d4af37; text-decoration:none; }
form { background:#1b1b1b; padding:20px; border-radius:8px; margin-bottom:30px; }
input, textarea { width:100%; padding:6px; margin-bottom:8px; }
button { padding:8px 15px; background:#d4af37; border:none; font-weight:bold; }
</style>
</head>

<body>

<h2>Gerenciar Personagens</h2>
<a href="index.php">← Voltar</a>

<hr>

<h3><?= $editar ? 'Editar' : 'Novo' ?> Personagem</h3>

<form method="post">
<input type="hidden" name="id" value="<?= $editar['id'] ?? '' ?>">

<?php
$campos = [
'nome','nivel','origem','vida_max','denarios','fisico','agilidade','inteligencia','carisma',
'poder_combate','poder_pontaria','medicina','intuicao','persuadir'
];
foreach ($campos as $c): ?>
<input name="<?= $c ?>" placeholder="<?= $c ?>" value="<?= $editar[$c] ?? '' ?>">
<?php endforeach; ?>

<textarea name="armas_e_dano" placeholder="Armas"><?= $editar['armas_e_dano'] ?? '' ?></textarea>
<textarea name="armadura_desc" placeholder="Armadura"><?= $editar['armadura_desc'] ?? '' ?></textarea>
<textarea name="inventario" placeholder="Inventário"><?= $editar['inventario'] ?? '' ?></textarea>
<textarea name="historia" placeholder="História"><?= $editar['historia'] ?? '' ?></textarea>

<button type="submit">Salvar</button>
</form>

<hr>

<h3>Lista de Personagens</h3>

<table>
<tr>
<th>ID</th>
<th>Nome</th>
<th>Nível</th>
<th>Ações</th>
</tr>

<?php foreach ($lista as $p): ?>
<tr>
<td><?= $p['id'] ?></td>
<td><?= htmlspecialchars($p['nome']) ?></td>
<td><?= $p['nivel'] ?></td>
<td>
<a href="?edit=<?= $p['id'] ?>">Editar</a> |
<a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Excluir?')">Excluir</a>
</td>
</tr>
<?php endforeach; ?>

</table>

</body>
</html>
