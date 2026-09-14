<?php

class Produto implements JsonSerializable
{
  private string $imagem;
  private string $nome;
  private float $preco;
  private int $vendas;
  private int $estoque;

  public function __construct(array $dados)
  {
    $this->nome = (string) ($dados['nome'] ?? '');
    $this->preco = (float) ($dados['preco'] ?? 0);
    $this->vendas = (int) ($dados['vendas'] ?? 0);
    $this->estoque = (int) ($dados['estoque'] ?? 0);
    $this->imagem = $this->definirImagem();
  }

  private function definirImagem(): string
  {
    return $this->nome === 'vinho' ? 'img/vinho1.jpg' : 'img/vinho.jpg';
  }

  public function getImagem(): string
  {
    return $this->imagem;
  }

  public function getNome(): string
  {
    return $this->nome;
  }

  public function getPreco(): float
  {
    return $this->preco;
  }

  public function getVendas(): int
  {
    return $this->vendas;
  }

  public function getEstoque(): int
  {
    return $this->estoque;
  }

  public function jsonSerialize(): array
  {
    return [
      'imagem' => $this->imagem,
      'nome' => $this->nome,
      'estoque' => $this->estoque,
      'preco' => $this->preco,
      'vendas' => $this->vendas,
    ];
  }
}

function transformarProdutos(array $dados): array
{
  return array_map(fn(array $produto): Produto => new Produto($produto), $dados);
}

function  RankVendas($conexao){
$comando = $conexao -> query("select nome, vendas from produtos  order by vendas  DESC");
$itens = $comando -> fetchAll(PDO::FETCH_ASSOC);
foreach($itens as $rank => $item){
  echo(" <p class='rank-item'>" .  ($rank + 1) . " {$item['nome']} </p> <br>");
}
};


function buscar($conexao, $q)
{
  try {
    $comando = $conexao->query("select * from produtos where nome like '$q%'");
    $produtos = $comando->fetchAll(PDO::FETCH_ASSOC);
    return transformarProdutos($produtos);
    //header("Refresh: 0");
  } catch (Exception $erro) {
    echo $erro;
  }
}


function adicionarProduto($conexao, $nome, $estoque, $preco, $vendas = null)
{
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }

  if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    return false;
  }

  if (!isset($_SESSION["tipo"]) || strtolower((string) $_SESSION["tipo"]) !== "empresa") {
    return false;
  }

  $nome = trim((string) $nome);
  $estoque = max(0, (int) $estoque);
  $preco = (float) $preco;

  if ($nome === "" || $preco <= 0) {
    return false;
  }

  $vendas = ($vendas === null || $vendas === "") ? null : max(0, (int) $vendas);

  try {
    $comando = $conexao->prepare("INSERT INTO produtos (nome, estoque, preco, vendas) VALUES (:nome, :estoque, :preco, :vendas)");
    return $comando->execute([
      ':nome' => $nome,
      ':estoque' => $estoque,
      ':preco' => $preco,
      ':vendas' => $vendas,
    ]);
  } catch (Exception $erro) {
    echo $erro;
    return false;
  }
}
function receberProdutos($conexao)
{
  try {
    $comando = $conexao->query("select * from produtos");
    $produtos = $comando->fetchAll(PDO::FETCH_ASSOC);
    return transformarProdutos($produtos);
  } catch (Exception $erro) {
    echo $erro;
  }
}
function receberProdutoEspecifico($conexao, $nome)
{
  try {
    $comando = $conexao->query("select * from produtos where nome = '$nome'");
    $produtos = $comando->fetchAll(PDO::FETCH_ASSOC);
    return $produtos[0];
  } catch (Exception $erro) {
    echo $erro;
  }
}
function modificarEstoque($conexao, $produto, $estoque)
{
  try {
    $comando = $conexao->query("update produtos set estoque = '$estoque' where nome = '$produto'");
  } catch (Exception $erro) {
    echo $erro;
  }
}
function mostrarProdutosDevs($conexao)
{
  $produtos = receberProdutos($conexao);
  for ($i = 0; $i < count($produtos); $i++) {
    echo "Nome: " . $produtos[$i]->getNome() . " | Estoque: " . $produtos[$i]->getEstoque() . " | ";
  }
}
function adicionarUsuario($conexao, $nome, $email, $usuario, $senha, $tipo, $tel)
{
  try {
    $comando = $conexao->query("insert into usuarios(nome, email, usuario, senha, tipo, tel) values('$nome', '$email', '$usuario', '$senha', '$tipo', '$tel')");
  } catch (Exception $erro) {
    echo $erro;
  }
}
function removerUsuario($conexao, $id)
{
  try {
    $comando = $conexao->query("delete from usuarios where id='$id'");
  } catch (Exception $erro) {
    echo $erro;
  }
}
