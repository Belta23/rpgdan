<?php
session_start();
require_once __DIR__ . '/env_admin.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $senha   = $_POST['senha'] ?? '';

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

        $stmt = $pdo->prepare(
            "SELECT usuario, senha FROM usuarios WHERE usuario = :u LIMIT 1"
        );
        $stmt->execute([':u' => $usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['usuario'] = $user['usuario'];
            header('Location: dashboard.php');
            exit;
        }

        $erro = "Usuário ou senha inválidos.";

    } catch (Throwable $e) {
        $erro = "Erro interno ao conectar ao banco.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Login Administrativo</title>
</head>
<body>

<h2>Login Administrativo</h2>

<?php if (!empty($erro)): ?>
    <p style="color:red"><?= htmlspecialchars($erro) ?></p>
<?php endif; ?>

<form method="post">
    <input type="text" name="usuario" placeholder="Usuário" required><br><br>
    <input type="password" name="senha" placeholder="Senha" required><br><br>
    <button type="submit">Entrar</button>
</form>
<a href="../index.php">🌍 Voltar ao site</a>i>
</body>
</html>
