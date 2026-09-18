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
    <main class="principal">

      <div class="pesquisa">
        <form method="POST" id="barra">
          <img src="img/lupa.png" height="30px" width="30px" alt="imagem de lupa">
          <input type="search" placeholder="pesquisar" name="q">
          <input type="button" value="Buscar" onclick="pesquisar()">
        </form>
      </div>
    <div class="rank_produtos">
      <div id="filtro">
        <div id="rank">
          <h3>Vinhos mais vendidos</h3>
          <?php
          
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
            echo "<div id='pesquisa-div'>";
            foreach ($produtos as $produto) {
              $nome = $produto["nome"];
              echo "<div class='item' onclick='irPraPagina(`$nome`)'>"; echo "teste";
              echo "<h3>" . $produto["nome"] . "</h3>";
              echo "<p>Estoque: " . $produto["estoque"] . "</p>";
              if($produto["nome"] == "vinho"){
                echo "<img src='img/vinho1.jpg' height='80px' width='80px' alt='imagem de vinho'>";
              }
              echo "<p>Preço: R$" . $produto["preco"] . "</p>";
              echo "<p>Vendas: " . $produto["vendas"] . "</p>";
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
    </script>
    <script src="script.js"></script>
</body>

</html>
