<?php
header("Content-Type: application/json; charset=UTF-8");
$json = json_decode(file_get_contents('php://input'), true);



function FiltrarBaratos($conexao){
    $comando = $conexao -> query("select * from produtos order by preco asc"); 
    $itens = $comando -> fetchAll(PDO::FETCH_ASSOC);
    return transformarProdutos($itens);
};

function FiltrarCaros($conexao){
    $comando = $conexao -> query("select * from produtos order by preco desc");
    $itens = $comando -> fetchAll(PDO::FETCH_ASSOC);
    return transformarProdutos($itens);
}
function FiltrarIntervalo($conexao,$min,$max){{
    $comando = $conexao -> query("select * from produtos where preco between '$min' and '$max'");
    $itens = $comando -> fetchAll(PDO::FETCH_ASSOC);
    return transformarProdutos($itens);
}
}

if($json['tipo'] == 'menor-maior'){
    include "connect.php";
    echo json_encode(FiltrarBaratos($conexao));
}
if($json['tipo'] == 'maior-menor'){
    include "connect.php";
    echo json_encode(FiltrarCaros($conexao));
}
if($json['tipo'] == 'minmax'){
    include "connect.php";
    echo json_encode(FiltrarIntervalo($conexao, $json['valor1'], $json['valor2']));
}






?>