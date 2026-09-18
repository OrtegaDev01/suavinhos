<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

if (isset($_SESSION["login"]) && $_SESSION["login"] === true) {
    header("Location: index.php");
    exit;
}

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
    <link rel="stylesheet" href="css/estilos.css">

</head>
<body id="login">
    <h2 id="titulo">Login</h2>

    <?php if ($erro !== ""): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>
<div>
    <form method="POST" id="cadastro_login">
    <div>
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br><br>
    </div>
        <div id="enviar"><input type="submit" value="Entrar"></div>
       
    </form>
    <div> <a href="registro.php">Ainda não tem uma conta? Registre-se</a> </div>
</div>
</body>
</html>
