<?php
session_start();
require_once __DIR__ . '/../env.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $senha   = $_POST['senha'] ?? '';

    try {
        $pdo = new PDO(
            "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
            $db_user,
            $db_pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = :u LIMIT 1");
        $stmt->execute([':u' => $usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['usuario'] = $user['usuario'];
            header('Location: dashboard.php');
            exit;
        }

        $erro = "Usuário ou senha inválidos.";
    } catch (Exception $e) {
        $erro = "Erro interno.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Login Admin</title>
</head>
<body>

<h2>Login Administrativo</h2>

<?php if (!empty($erro)): ?>
<p style="color:red"><?= $erro ?></p>
<?php endif; ?>

<form method="post">
    <input type="text" name="usuario" placeholder="Usuário" required><br><br>
    <input type="password" name="senha" placeholder="Senha" required><br><br>
    <button type="submit">Entrar</button>
</form>

</body>
</html>
