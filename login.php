<?php
session_start();
require "php/connect.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? "");
    $senha = trim($_POST["senha"] ?? "");

    if ($usuario === "" || $senha === "") {
        $erro = "Preencha usuário e senha.";
    } else {
        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE usuario = :usuario AND senha = :senha LIMIT 1");
        $stmt->execute([
            ":usuario" => $usuario,
            ":senha" => $senha,
        ]);

        $usuarioBanco = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuarioBanco) {
            $_SESSION["login"] = true;
            $_SESSION["usuario"] = $usuarioBanco["usuario"];
            $_SESSION["nome"] = $usuarioBanco["nome"];
            $_SESSION["tipo"] = $usuarioBanco["tipo"];

            header("Location: index.php");
            exit;
        } else {
            $erro = "Usuário ou senha inválidos.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <?php if ($erro !== ""): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br><br>
        
        <input type="submit" value="Entrar">git con
    </form>
    <a href="registro.php">Ainda não tem uma conta? Registre-se</a>
</body>
</html>
