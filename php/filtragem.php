<?php
header("Content-Type: application/json; charset=UTF-8");
$json = json_decode(file_get_contents('php://input'), true);



function FiltrarBaratos($conexao){
    $comando = $conexao -> query("select * from produtos order by preco asc"); 
    $itens = $comando -> fetchAll(PDO::FETCH_ASSOC);
    return $itens;
};

function FiltrarCaros($conexao){
    $comando = $conexao -> query("select * from produtos order by preco desc");
    $itens = $comando -> fetchAll(PDO::FETCH_ASSOC);
    return $itens;
}
function FiltrarIntervalo($conexao,$min,$max){{
    $comando = $conexao -> query("select * from produtos and preco between $min and $max");
    $itens = $comando -> fetchAll(PDO::FETCH_ASSOC);
    return $itens;
}
}






?>