<?php
$host = "localhost";
$db = "suavinhos";
$user = "root";
$senha = "senha";

try {
  $conexao;
  $conexao = new PDO("mysql:host=$host; dbname=$db;", $user, $senha);
} catch (Exception $erro) {
  echo $erro;
}
