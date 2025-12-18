<?php
// ================================
// DEBUG (pode remover depois)
// ================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================
// CONFIG
// ================================
require_once __DIR__ . '/env.php';

// ================================
// VALIDAÇÃO DO ID
// ================================
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('ID do personagem inválido.');
}

$id = (int) $_GET['id'];

if ($id <= 0) {
    die('ID do personagem inválido.');
}

// ================================
// CONEXÃO COM O BANCO
// ================================
try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die('Erro ao conectar no banco.');
}

// ================================
// BUSCA POR ID (SEM SLUG, SEM LIKE)
// ================================
$sql = "SELECT * FROM personagens_rpg WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$personagem = $stmt->fetch();

if (!$personagem) {
    die('Personagem não encontrado.');
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($personagem['nome']) ?> • Crônicas da Mesa</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;800&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

<style>
body {
    margin: 0;
    background: #0f0f14;
    color: #e6e6eb;
    font-family: 'Inter', sans-serif;
}

header {
    text-align: center;
    padding: 2rem 1rem;
}

header h1 {
    font-family: 'Cinzel', serif;
    color: #d4af37;
    margin: 0;
}

.container {
    max-width: 900px;
    margin: auto;
    padding: 1rem;
}

.card {
    background: #1a1a24;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.card h2 {
    font-family: 'Cinzel', serif;
    color: #d4af37;
    margin-top: 0;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
}

.stat {
    background: #13131c;
    padding: 0.8rem;
    border-radius: 10px;
    text-align: center;
}

.stat strong {
    display: block;
    color: #d4af37;
}
</style>
</head>

<body>

<header>
    <h1><?= htmlspecialchars($personagem['nome']) ?></h1>
    <p><?= htmlspecialchars($personagem['origem']) ?> • Nível <?= (int)$personagem['nivel'] ?></p>
</header>

<div class="container">

<div class="card">
    <h2>Atributos</h2>
    <div class="grid">
        <div class="stat"><strong>Vida</strong><?= (int)$personagem['vida_max'] ?></div>
        <div class="stat"><strong>Físico</strong><?= (int)$personagem['fisico'] ?></div>
        <div class="stat"><strong>Agilidade</strong><?= (int)$personagem['agilidade'] ?></div>
        <div class="stat"><strong>Inteligência</strong><?= (int)$personagem['inteligencia'] ?></div>
        <div class="stat"><strong>Carisma</strong><?= (int)$personagem['carisma'] ?></div>
    </div>
</div>

<div class="card">
    <h2>Combate</h2>
    <p><strong>Armas:</strong> <?= htmlspecialchars($personagem['armas_e_dano']) ?></p>
    <p><strong>Armadura:</strong> <?= htmlspecialchars($personagem['armadura_desc']) ?></p>
</div>

<div class="card">
    <h2>Inventário</h2>
    <p><?= htmlspecialchars($personagem['inventario']) ?></p>
</div>

<div class="card">
    <h2>História</h2>
    <p><?= nl2br(htmlspecialchars($personagem['historia'])) ?></p>
</div>

</div>

</body>
</html>
