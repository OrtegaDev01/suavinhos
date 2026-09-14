<?php
session_start();
require "php/connect.php";
require "php/functions.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $usuario = trim($_POST["usuario"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $senha = trim($_POST["senha"] ?? "");
    $tipo = trim($_POST["tipo"] ?? "Cliente");
    $tel = trim($_POST["tel"] ?? "");

    if ($nome === "" || $usuario === "" || $email === "" || $senha === "") {
        $erro = "Preencha nome, usuário, email e senha.";
    } else {
        $verifica = $conexao->prepare("SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email LIMIT 1");
        $verifica->execute([
            ":usuario" => $usuario,
            ":email" => $email,
        ]);

        if ($verifica->fetch()) {
            $erro = "Usuário ou email já cadastrados.";
        } else {
            adicionarUsuario($conexao, $nome, $email, $usuario, $senha, $tipo, $tel);

            $_SESSION["login"] = true;
            $_SESSION["usuario"] = $usuario;
            $_SESSION["nome"] = $nome;
            $_SESSION["tipo"] = $tipo;

            header("Location: index.php");
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>
<body>
    <h2>Cadastro</h2>

    <?php if ($erro !== ""): ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required><br><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br><br>

        <label for="tel">Telefone:</label>
        <input type="text" name="tel" id="tel"><br><br>

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo">
            <option value="Cliente">Cliente</option>
            <option value="Empresa">Empresa</option>
        </select><br><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html>
