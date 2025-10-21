<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Pagina de exclusão de Servicos";
require 'cabecalho.php';

if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}

require 'Conexao.php';  

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

echo "<p><b>ID:</b> $id</p>";

$sql = "DELETE FROM servicos WHERE id = ?"; 
            

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id]);

$count = $stmt->rowCount();

if($result == true && $count >= 1){
    //deu certo insert
    ?>
    <div class="alert alert-success" role="alert">
        <h4>Serviço excluido com sucesso</h4>
    </div>

    <?php
} elseif ($count -= 0) {
    ?>
        <div class="alert alert-danger" role="alert">
            <h4>Falha ao efetuar exclusão</h4>
            <p>Não foi encontrado nenhum serviço com o ID = <?= $id?></p>
        </div>

    <?php
    
} else {
    //nao deu certo, erro
    $errorArray = $stmt->errorInfo();
    ?>
    <div class="alert alert-danger" role="alert">
        <h4>Falha ao efetuar exclusão</h4>
        <p><?=$errorArray[2]; ?></p>
    </div>

    <?php
}
require 'rodape.php'

?>