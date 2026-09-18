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

      <div class="pesquisa">
      <form method="POST" id="barra">
        <img src="img/lupa.png" height="30px" width="30px" alt="imagem de lupa">
        <input type="search" placeholder="pesquisar" name="q">
        <input type="button" value="Buscar" onclick="<?php
                                                      if ($_SERVER["REQUEST_METHOD"] === 'POST') {
                                                        require_once("./php/connect.php");
                                                        require_once("./php/functions.php");
                                                        $q = $_POST["q"];
                                                        buscar($conexao, $q);
                                                      }

                                                      ?>">
      </form>
      <div>

      <div id="filtro">
        <div id="rank">
          <?php
          require_once("./php/connect.php");
          require_once("./php/functions.php");
          RankVendas($conexao);
          ?>

        </div>
        <div id="filtro-popup">
          <input type="button" value="Filtrar" id="popup">
        </div>



      </div>
      <div id="div-itens">
        <h2>Produtos</h2>
        <?php
          $produtos = receberProdutos($conexao);
          foreach ($produtos as $produto) {
            echo "<div class='item'>";
            echo "<h3>" . $produto["nome"] . "</h3>";
            echo "<p>Estoque: " . $produto["estoque"] . "</p>";
            if($produto["nome"] == "vinho"){
              echo "<img src='img/vinho1.jpg' alt='imagem de vinho'>";
            }
            echo "<p>Preço: R$" . $produto["preco"] . "</p>";
            echo "<p>Vendas: " . $produto["vendas"] . "</p>";
            echo "</div>";
          }
        ?>
      </div>
    </main>

    <footer class="footer">
    <b>Marlon, Felipe Ortega, Miguel</b>
    </footer>

    <script src="script.js"></script>
</body>

</html>
