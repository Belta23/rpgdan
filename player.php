<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/env.php';

if (!isset($_GET['id'])) {
    die('Personagem não informado.');
}

$id = strtolower($_GET['id']); // converte para minúsculas para facilitar a busca

// ================================
// CONEXÃO
// ================================
try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('Erro de conexão com o banco: ' . $e->getMessage());
}

// ================================
// BUSCA DO PERSONAGEM
// ================================
// Busca por nome ou slug
$sql = "SELECT * FROM personagens_rpg 
        WHERE LOWER(nome) LIKE :nome OR LOWER(slug) LIKE :nome
        LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome' => "%$id%"
]);

$personagem = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$personagem) {
    die('Personagem não encontrado.');
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?php echo htmlspecialchars($personagem['nome']); ?> • Crônicas da Mesa</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
<style>
:root {
    --bg-dark:#0f0f14;
    --bg-card:#1a1a24;
    --gold:#d4af37;
    --text:#e6e6eb;
    --muted:#9aa0a6;
}
body {
    margin:0;
    background:radial-gradient(circle at top,#1c1c28,var(--bg-dark));
    color:var(--text);
    font-family:'Inter',sans-serif;
}
.container {
    max-width: 1000px;
    margin: 2rem auto;
    padding: 1rem;
}
.card {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.5);
}
.card h1 {
    font-family:'Cinzel',serif;
    color: var(--gold);
}
.card p {
    color: var(--muted);
    line-height: 1.5;
}
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <h1><?php echo htmlspecialchars($personagem['nome']); ?></h1>
        <p><strong>Nível:</strong> <?php echo $personagem['nivel']; ?></p>
        <p><strong>Origem:</strong> <?php echo htmlspecialchars($personagem['origem']); ?></p>
        <p><strong>Vida:</strong> <?php echo $personagem['vida_max']; ?></p>
        <p><strong>Denários:</strong> <?php echo $personagem['denarios']; ?></p>
        <p><strong>Força:</strong> <?php echo $personagem['fisico']; ?></p>
        <p><strong>Agilidade:</strong> <?php echo $personagem['agilidade']; ?></p>
        <p><strong>Inteligência:</strong> <?php echo $personagem['inteligencia']; ?></p>
        <p><strong>Carisma:</strong> <?php echo $personagem['carisma']; ?></p>
        <p><strong>Poder de Combate:</strong> <?php echo $personagem['poder_combate']; ?></p>
        <p><strong>Poder de Pontaria:</strong> <?php echo $personagem['poder_pontaria']; ?></p>
        <p><strong>Medicina:</strong> <?php echo $personagem['medicina']; ?></p>
        <p><strong>Intuição:</strong> <?php echo $personagem['intuicao']; ?></p>
        <p><strong>Persuasão:</strong> <?php echo $personagem['persuadir']; ?></p>
        <p><strong>Armas e Dano:</strong> <?php echo htmlspecialchars($personagem['armas_e_dano']); ?></p>
        <p><strong>Armadura:</strong> <?php echo htmlspecialchars($personagem['armadura_desc']); ?></p>
        <p><strong>Inventário:</strong> <?php echo htmlspecialchars($personagem['inventario']); ?></p>
        <p><strong>História:</strong> <?php echo htmlspecialchars($personagem['historia']); ?></p>
    </div>
</div>
</body>
</html>
