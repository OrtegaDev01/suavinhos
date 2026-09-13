<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Suavinhos</title>
</head>

<body>

  <header>
    <h1> Suavinhos </h1>
    <main>
      <form method="POST">
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

    <footer>
    </footer>

    <script src="script.js"></script>
  </header>
</body>

</html>