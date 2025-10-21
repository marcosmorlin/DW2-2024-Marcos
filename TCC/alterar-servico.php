<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Alteração de Servicos";
require 'cabecalho.php';

require 'Conexao.php';  

$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
//$foto_servico = filter_input(INPUT_POST, "foto_servico", FILTER_SANITIZE_SPECIAL_CHARS);

$foto_servico = null;


if(isset($_FILES["foto_servico"]) && $_FILES["foto_servico"] ["error"] === UPLOAD_ERR_OK){
    
    $tmp_name = $_FILES["foto_servico"]["tmp_name"];
    $foto_servico = $_FILES["foto_servico"]["name"];
    if(move_uploaded_file($tmp_name, "img/" . $foto_servico)){
        echo "<p class= 'text alert-success d-inline-block'>Arquivo enviado !!!</p>"; 
    } else {
        echo "Erro ao enviar a foto";
    } 
}

if(!$foto_servico){
    $sqlImg = "SELECT foto_servico FROM servicos WHERE id = ? ";
    $stmtImg = $conn->prepare($sqlImg);
    $stmtImg->execute([$id]);
    $result = $stmtImg->fetch();

    if($result){
        $foto_servico = $result['foto_servico'];
    }
}

echo "<p><b>ID:</b> $id</p>";
echo "<p><b>Nome:</b> $nome</p>";
echo "<p><b>descricao:</b> $descricao</p>";
if($foto_servico){

    echo "<p><b>foto_servico:</b> $foto_servico</p>";

} else {

    echo "<p><b>foto_servico:</b> <span class='text alert-info d-inline-block'>NULL</span>";
}

$sql = "UPDATE servicos SET nome = ?, descricao = ?, foto_servico = ?
            WHERE id = ?";
            
$stmt = $conn->prepare($sql);
$result = $stmt->execute([$nome, $descricao, $foto_servico, $id]);
$count = $stmt->rowCount();

if($result == true && $count >= 1){
    //deu certo insert
    ?>
    <div class="alert alert-success" role="alert">
        <h4>Dados alterados com sucesso</h4>
    </div>

    <p>
        <a href="meus-servicos.php" class="btn btn-sm btn-warning">
            <span data-feather="arrow-left"></span>
            Voltar
        </a>
    </p>

    <?php
}  elseif ($result == true && $count == 0) {
    ?> 

    <div class="alert alert-secondary" role="alert">
        <h4>Nenhum dado foi alterado</h4>
    </div>

    <p>
        <a href="meus-servicos.php" class="btn btn-sm btn-warning">
            <span data-feather="arrow-left"></span>
            Voltar
        </a>
    </p>

    <?php
} else {
    //nao deu certo, erro
    $errorArray = $stmt->errorInfo();
    ?>
    <div class="alert alert-danger" role="alert">
        <h4>Falha ao efetuar alteração</h4>
        <p><?=$errorArray[2]; ?></p>
    </div>

    <p>
        <a href="meus-servicos.php" class="btn btn-sm btn-warning">
            <span data-feather="arrow-left"></span>
            Voltar
        </a>
    </p>

    <?php
}
require 'rodape.php'

?>