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
    <main>

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
      <div id="div-itens"></div>
    </main>

    <footer class="footer">
      <h4>Marlon, Felipe Ortega, Miguel</h4>
    </footer>

    <script src="script.js"></script>
</body>

</html>
