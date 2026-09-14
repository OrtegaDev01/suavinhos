<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["logout"])) {
  $_SESSION = [];
  session_unset();
  session_destroy();
  header("Location: login.php");
  exit;
}

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
  <?php 
    require_once "php/connect.php";
    require_once "php/functions.php";
  ?>
  <title>Suavinhos</title>
</head>

<body class="corpo">

  <header class="header">
    <h1> Suavinhos </h1> 
  </header>

  <form method="POST" action="index.php" style="margin: 10px 0 0 20px;">
    <button type="submit" name="logout" value="1">Logout</button>
  </form>

    <main class="principal">

      <div class="pesquisa">
        <form method="POST" id="barra">
          <img src="img/lupa.png" height="30px" width="30px" alt="imagem de lupa">
          <input type="search" placeholder="Pesquisar" name="q">
          <input type="button" value="Buscar" onclick="pesquisar()">
        </form>
      </div>
    <div class="rank_e_produtos">


      <div id="filtro">
        <div id="rank">
          <h3>Vinhos mais vendidos</h3>
          <?php
          
          RankVendas($conexao);
          ?>

        </div>



      </div>
    

      <div id="filtro">
        <h3>Filtrar</h3>
        <form method="POST" id="filtro-preco">
          <label for="preco">Preço:</label>
          <input type="number" name="preco-min" id='preco-min' placeholder="Mínimo">
          <input type="number" name="preco-max" id='preco-max' placeholder="Máximo">
          <input type="button" value="Filtrar" onclick="filtrar('minmax')">
        </form>
        <form method="POST" id="filtro-menor-maior">
          <label for="preco">Do menor para o maior:</label>
          <input type="button" value="Filtrar" onclick="filtrar('menor-maior')">
        </form>
        <form method="POST" id="filtro-maior-menor">
          <label for="preco">Do maior para o menor:</label>
          <input type="button" value="Filtrar" onclick="filtrar('maior-menor')">
        </form>
      </div>


      <div id="div-itens">
        <h2>Produtos</h2>
          <?php
            $produtos = receberProdutos($conexao);
            echo "<div id='pesquisa-div'>";
            foreach ($produtos as $produto) {
              echo "<div class='item' onclick='irPraPagina(" . htmlspecialchars(json_encode($produto->getNome()), ENT_QUOTES, 'UTF-8') . ")'>";
              echo "<h3>" . htmlspecialchars($produto->getNome(), ENT_QUOTES, 'UTF-8') . "</h3>";
              echo "<img src='" . htmlspecialchars($produto->getImagem(), ENT_QUOTES, 'UTF-8') . "' height='80px' width='80px' alt='imagem de vinho'>";
              echo "<p>Estoque: " . $produto->getEstoque() . "</p>";
              echo "<p>Preço: R$" . $produto->getPreco() . "</p>";
              echo "<p>Vendas: " . $produto->getVendas() . "</p>";
              echo "</div>";
            }
            echo "</div>";
          ?>
        
      </div>
         
          </div>
    </main>

    <footer class="footer">
    <b>Marlon, Felipe Ortega, Miguel</b>
    </footer>

    <script>
      function irPraPagina(nome) {
        window.location.href = "produto.php?nome=" + nome;
      }
      async function pesquisar(){
        fetch("php/pesquisar.php", {
          method: "POST",
          headers:{
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            q: document.querySelector("input[name='q']").value
          })
        }).then(response => response.json())
        .then(data => {
          const divItens = document.getElementById("pesquisa-div");
          divItens.innerHTML = "";
          data.forEach(produto => {
            const itemDiv = document.createElement("div");
            itemDiv.classList.add("item");
            itemDiv.onclick = () => irPraPagina(produto.nome);
            if(produto.nome == 'vinho'){
              imagem = 'img/vinho1.jpg';
            } else {
              imagem = 'img/vinho.jpg';
            }
            itemDiv.innerHTML = `
              <h3>${produto.nome}</h3>
              <img src=${imagem} height='150px' width='120px' alt='imagem de vinho'>
              <p>Estoque: ${produto.estoque}</p>
              <p>Preço: R$${produto.preco}</p>
              <p>Vendas: ${produto.vendas}</p>
            `;
            divItens.appendChild(itemDiv);
          });
        });
      }

      async function filtrar(tipo){
        if(tipo == 'minmax'){
          valor1 = document.getElementById('preco-min').value;
          valor2 = document.getElementById('preco-max').value;
        } else {
          valor1 = null;
          valor2 = null;
        }
        
        fetch("php/filtragem.php", {
          method: "POST",
          headers:{
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            tipo: tipo,
            valor1: valor1,
            valor2: valor2
          })
        }).then(response => response.json())
        .then(data => {
          const divItens = document.getElementById("pesquisa-div");
          divItens.innerHTML = "";
          data.forEach(produto => {
            const itemDiv = document.createElement("div");
            itemDiv.classList.add("item");
            itemDiv.onclick = () => irPraPagina(produto.nome);
            if(produto.nome == 'vinho'){
              imagem = 'img/vinho1.jpg';
            } else {
              imagem = 'img/vinho.jpg';
            }
            itemDiv.innerHTML = `
              <h3>${produto.nome}</h3>
              <img src=${imagem} height='150px' width='120px' alt='imagem de vinho'>
              <p>Estoque: ${produto.estoque}</p>
              <p>Preço: R$${produto.preco}</p>
              <p>Vendas: ${produto.vendas}</p>
            `;
            divItens.appendChild(itemDiv);
          });
        });
      }
    </script>
    <script src="script.js"></script>
</body>

</html>
