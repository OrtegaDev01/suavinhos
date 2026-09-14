<?php
$host = "localhost";
$db = "suavinhos";
$user = "justiniano";
$senha = "niggabomber";

try {
  $conexao;
  $conexao = new PDO("mysql:host=$host; dbname=$db;", $user, $senha);
} catch (Exception $erro) {
  echo $erro;
}
