<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/env.php';



if (!isset($_GET['id'])) {
die('Personagem não informado.');
}


$id = $_GET['id'];


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
die('Erro de conexão com o banco.');
}


// ================================
// BUSCA DO PERSONAGEM
// ================================
$sql = "SELECT * FROM personagens_rpg WHERE LOWER(nome) LIKE :nome LIMIT 1";
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
header {
text-align:center;
padding:2.5rem 1rem;
}
header h1 {
font-family:'Cinzel',serif;
