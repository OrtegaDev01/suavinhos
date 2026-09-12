<?php
    function adicionarProduto($conexao, $nome, $estoque){
        try{
            $comando = $conexao->query("insert into produtos(nome, estoque) values('$nome', '$estoque')");
        } catch(Exception $erro){
            echo $erro;
        }
    }
    function receberProdutos($conexao){
        try{
            $comando = $conexao->query("select * from produtos");
            $produtos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return $produtos;
        } catch(Exception $erro){
            echo $erro;
        }
    }
    function receberProdutoEspecifico($conexao, $nome){
        try {
            $comando = $conexao->query("select * from produtos where nome = '$nome'");
            return $comando->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $erro){
            echo $erro;
        }
    }
    function modificarEstoque($conexao, $produto, $estoque){
        try{
            $comando = $conexao->query("update produtos set estoque = '$estoque' where nome = '$produto'");
        } catch(Exception $erro){
            echo $erro;
        }
    }
    function mostrarProdutosDevs($conexao){
        $produtos = receberProdutos($conexao);
        for($i = 0; $i < count($produtos); $i++){
            echo "Nome: " . $produtos[$i]["nome"] . " | Estoque: " . $produtos[$i]["estoque"] . " | ";
        }
    }
    function adicionarUsuario($conexao, $nome, $email, $usuario, $senha, $tipo, $tel){
        try {
            $comando = $conexao->query("insert into usuarios(nome, email, usuario, senha, tipo, tel) values('$nome', '$email', '$usuario', '$senha', '$tipo', '$tel')");
        } catch (Exception $erro){
            echo $erro;
        }
    }
    function removerUsuario($conexao, $id){
        try {
            $comando = $conexao->query("delete from usuarios where id='$id'");
        } catch (Exception $erro){
            echo $erro;
        }
    }