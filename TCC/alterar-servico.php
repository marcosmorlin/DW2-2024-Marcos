<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Pagina de alteração de Servicos";
require 'cabecalho.php';

require 'Conexao.php';  

$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);

echo "<p><b>ID:</b> $id</p>";
echo "<p><b>Nome:</b> $nome</p>";
echo "<p><b>descricao:</b> $descricao</p>";

$sql = "UPDATE servicos SET nome = ?,  descricao = ?
            WHERE id = ?";
            

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$nome, $descricao, $id]);
$count = $stmt->rowCount();

if($result == true && $count >= 1){
    //deu certo insert
    ?>
    <div class="alert alert-success" role="alert">
        <h4>Dados alterados com sucesso</h4>
    </div>

    <?php
}  elseif ($result == true && $count == 0) {
    ?> 

    <div class="alert alert-secondary" role="alert">
        <h4>Nenhum dado foi alterado</h4>
    </div>

    <?php
} else {
    //nao deu certo, erro
    $errorArray = $stmt->errorInfo();
    ?>
    <div class="alert alert-danger" role="alert">
        <h4>Falha ao efetuar alteração</h4>
        <p><?=$errorArray[2]; ?></p>
    </div>

    <?php
}
require 'rodape.php'

?>