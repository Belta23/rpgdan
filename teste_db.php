<?php
require_once __DIR__ . '/env.php';

echo "<pre>";

try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8",
        $db_user,
        $db_pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "✅ Conectado com sucesso ao banco!";

} catch (PDOException $e) {
    echo "❌ ERRO PDO:\n";
    echo $e->getMessage();
}
