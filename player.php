<?php
// ================================
// DEBUG (remova em produção)
// ================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ================================
// CONFIG
// ================================
require_once __DIR__ . '/env.php';

// ================================
// VALIDAÇÃO DA URL
// ================================
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Personagem não informado.');
}

// Normaliza o termo recebido
$id = $_GET['id'];
$nomeBusca = strtolower($id);
$nomeBusca = str_replace('-', ' ', $nomeBusca);
$nomeBusca = trim($nomeBusca);

// ================================
// CONEXÃO PDO
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
    die('Erro de conexão com o banco.');
}

// ================================
// BUSCA DO PERSONAGEM
// ================================
$sql = "
    SELECT *
    FROM personagens_rpg
    WHERE LOWER(nome) LIKE :nome
    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':nome' => '%' . $nomeBusca . '%'
]);

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
:root {
    --bg-dark: #0f0f14;
    --bg-card: #1a1a24;
    --gold: #d4af37;
    --text: #e6e6eb;
    --muted: #9aa0a6;
}

body {
    margin: 0;
    background: radial-gradient(circle at top, #1c1c28, var(--bg-dark));
    color: var(--text);
    font-family: 'Inter', sans-serif;
}

header {
    text-align: center;
    padding: 2.5rem 1rem;
}

header h1 {
    font-family: 'Cinzel', serif;
    font-size: 2.2rem;
    color: var(--gold);
    margin: 0;
}

header span {
    color: var(--muted);
}

.container {
    max-width: 900px;
    margin: auto;
    padding: 1rem;
}

.card {
    background: var(--bg-card);
    border-radius: 14px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.card h2 {
    font-family: 'Cinzel', serif;
    color: var(--gold);
    margin-top: 0;
}

.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
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
    color: var(--gold);
    font-size: 1.1rem;
}

footer {
    text-align: center;
    padding: 2rem;
    color: var(--muted);
    font-size: 0.85rem;
}
</style>
</head>

<body>

<header>
    <h1><?= htmlspecialchars($personagem['nome']) ?></h1>
    <span><?= htmlspecialchars($personagem['origem']) ?> • Nível <?= (int)$personagem['nivel'] ?></span>
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

<footer>
    Crônicas da Mesa • RPG
</footer>

</body>
</html>
