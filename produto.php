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
            ?>
        </div>
    </main>

    <footer class="footer">
    <b>Marlon, Felipe Ortega, Miguel</b>
    </footer>

    <script src="script.js"></script>
</body>

</html>
