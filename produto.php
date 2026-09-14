<?php
session_start();

if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/estilos.css">
  <title>Suavinhos</title>
</head>

<body class="corpo">

  <header class="header">
    <h1> Suavinhos </h1> 
  </header>
    <main class="principal">
        <div id='produto-div'>
            <?php
                require "php/connect.php";
                require "php/functions.php";
                $nome = $_GET['nome'];
                echo "<h2>Produto: $nome</h2>";
                if($nome == "vinho"){
                    $imagem = "vinho1";
                } else{
                    $imagem = "vinho";
                }
                echo "<img src='img/$imagem.jpg' alt='Imagem do vinho' width='200px' height='200px'>";
                echo "<h3>Estoque: " . receberProdutoEspecifico($conexao, $nome)['estoque'] . "</h3>";
                echo "<h3>Preço: R$" . receberProdutoEspecifico($conexao, $nome)['preco'] . "</h3>";
            ?>
            <button onclick="window.location.href='index.php'">Voltar</button>
            <button onclick="comprar('<?php echo $nome; ?>')">Comprar</button>
        </div>
    </main>

    <footer class="footer">
    <b>Marlon, Felipe Ortega, Miguel</b>
    </footer>

    <script src="script.js"></script>
    <script>
        
        function comprar(nome) {
            fetch('php/comprar.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nome: nome })
            })
            .then(response => response.json())
            .then(data => {
                if (data["status"] === "sucesso") {
                    alert('Compra realizada com sucesso!');
                    window.location.href = 'index.php';
                } else {
                    alert('Erro ao realizar a compra: ' + data["message"]);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao processar a compra.');
            });
        }
    </script>
</body>

</html>
