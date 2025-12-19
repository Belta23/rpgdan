<?php
session_start();
require_once __DIR__ . '/../env.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id'])) {
    die('ID não informado');
}

$id = (int) $_GET['id'];

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $stmt = $pdo->prepare("DELETE FROM personagens_rpg WHERE id = :id");
    $stmt->execute([':id' => $id]);

    header('Location: personagens.php');
    exit;

} catch (Exception $e) {
    die('Erro ao excluir personagem.');
}
