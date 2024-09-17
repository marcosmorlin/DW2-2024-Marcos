<?php

$titulo_pagina = "página de exclusão de produtos";
require 'cabeçalho.php';

/** Tratamento de permissoes */
if(!autenticado() || !isAdmin()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}   
/** Tratamento de permissoes */

require 'Conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

echo "<p><b>ID:</b> $id</p>";

$sql= "DELETE FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id]);

$count = $stmt->rowCount();

if($result == true && $count >= 1){
    //deu certo insert
    ?>
    <div class="alert alert-success" role="alert">
        <h4>Registro excluido sucesso</h4>
    </div>

    <?php
} elseif($count == 0){
    ?>

    <div class="alert alert-danger" role="alert">
        <h4>Falha ao efetuar exclusão</h4>
        <p>Não foi encotrado nenhum registro com o ID = <?php $id ?>.</p>
    </div>

    <?php
    
}  else
    {
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