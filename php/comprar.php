<?php
    include "connect.php";
    include "functions.php";
    header("Content-Type: application/json; charset=UTF-8");
    $json = json_decode(file_get_contents('php://input'), true);
    $produto = receberProdutoEspecifico($conexao, $json['nome']);
    if ($produto['estoque'] <= 0) {
        $dados = ["status" => "erro", "message" => "Produto fora de estoque"];
        echo json_encode($dados);
        exit;
    }
    $novoEstoque = $produto['estoque'] - 1;
    modificarEstoque($conexao, $json['nome'], $novoEstoque);
    $dados = ["status" =>"sucesso"];
    echo json_encode($dados);