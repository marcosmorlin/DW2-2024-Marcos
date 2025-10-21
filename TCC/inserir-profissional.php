<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Pagina de inserção de profissional";
require 'cabecalho.php';

require 'Conexao.php';  

$telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_SPECIAL_CHARS);
$rede_social = filter_input(INPUT_POST, "rede_social", FILTER_SANITIZE_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
$id_usuario = $_SESSION['idUsuario'];

echo "<p><b>telefone:</b> $telefone</p>";
echo "<p><b>rede_social:</b> $rede_social</p>";
echo "<p><b>descricao:</b> $descricao</p><br>";

// Verifica se existe um profissional 
$sqlVerificar = "SELECT id FROM profissionais WHERE id_usuario = ?";
$stmtVerifica = $conn->prepare($sqlVerificar);
$stmtVerifica->execute([$id_usuario]);

if($stmtVerifica->fetch()){
  echo "<script>alert('Já está cadastrado como profissional');</script>";
  exit();
}

// Insere os dados do profissional
$sql_profissionais = "INSERT INTO profissionais(telefone, rede_social, descricao, id_usuario) 
                      VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_profissionais);
$result_profissional = $stmt->execute([$telefone, $rede_social, $descricao, $id_usuario]);

if ($result_profissional) {
    $id_profissional = $conn->lastInsertId();
    $_SESSION["id_profissional"] = $id_profissional;
    
    echo '<div class="alert alert-success" role="alert">
            <h4>Dados gravados com sucesso</h4>
            <p>
                    Clique <a href= "meus-servicos.php">aqui</a>
                    para cadastrar seus serviços.
                </p>
          </div>';
          
} else {
    echo "<div class='alert alert-danger' role='alert'>
            <h4>Falha ao gravar os dados do profissional</h4>
          </div>";
}

require 'rodape.php';

?>
