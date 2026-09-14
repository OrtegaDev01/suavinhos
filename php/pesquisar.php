<?php
    include "connect.php";
    include "functions.php";
    header("Content-Type: application/json; charset=UTF-8");

    $json = json_decode(file_get_contents('php://input'), true);

    echo  json_encode(buscar($conexao, $json['q']));
    