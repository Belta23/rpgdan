<?php
require_once 'auth.php';
require_once __DIR__ . '/../env.php';

if (!isset($_GET['id'])) {
    die('ID inválido');
}

$pdo = new PDO(
    "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
    $db_user,
    $db_pass
);

$stmt = $pdo->prepare("DELETE FROM personagens_rpg WHERE id = :id");
$stmt->execute([':id' => $_GET['id']]);

header('Location: personagens_listar.php');
exit;

