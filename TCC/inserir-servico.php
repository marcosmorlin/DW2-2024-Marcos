<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Pagina de inserção de Servicos";
require 'cabecalho.php';

require 'Conexao.php';

$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
//$foto_servico = filter_input(INPUT_POST, "foto_servico", FILTER_SANITIZE_SPECIAL_CHARS);

$foto_servico = null;

if(isset($_FILES["foto_servico"]) && $_FILES["foto_servico"] ["error"] === UPLOAD_ERR_OK){

    $foto_servico = $_FILES["foto_servico"]["name"];
    $tmp = $_FILES["foto_servico"]["tmp_name"];
    move_uploaded_file($tmp, "img/" . $foto_servico);
    echo "<p class= 'text alert-success d-inline-block'>Arquivo enviado !!!</p>"; 
    
} elseif(isset($_FILES["foto_servico"]) && $_FILES["foto_servico"] ["error"] === UPLOAD_ERR_NO_FILE) {

    $foto_servico = null;

} else {
    echo "<p class= 'text alert-danger d-inline-block'>Erro ao enviar a foto</p>";
}

echo "<p><b>Nome:</b> $nome</p>";
echo "<p><b>descricao:</b> $descricao</p>";
if($foto_servico){

    echo "<p><b>foto_servico:</b> $foto_servico</p>";

} else {

    echo "<p><b>foto_servico:</b> <span class='text-info'>NULL</span></p>";
}

$id_usuario = $_SESSION['idUsuario'];

// Insere os dados na tabela "servicos"
$sqlInserirServico = "INSERT INTO servicos(nome, descricao, foto_servico) VALUES (?, ?, ?)";
$stmtServico = $conn->prepare($sqlInserirServico);
$stmtServico->execute([$nome, $descricao, $foto_servico]);


$id_servico = $conn->lastInsertId();

//verificar se existe profissional
$sql = "SELECT id FROM profissionais WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$id_usuario]);
$resultProfissional = $stmt->fetch();

    //se existir profissional
    if ($resultProfissional) {
        $id_profissional = $resultProfissional["id"];

        // Insere os dados na tabela "servicos-profissional"
        $sql_servico = "INSERT INTO servico_profissional (id_profissional, id_servico) VALUES (?, ?)";
        $stmt_servico = $conn->prepare($sql_servico);
        $result_servico = $stmt_servico->execute([$id_profissional, $id_servico]);

        if ($result_servico == true) {
            //deu certo insert

            ?>
            <div class="alert alert-success" role="alert">
                <h4>Dados cadastrados com sucesso</h4>
            </div>

            <a href="meus-servicos.php" class="btn btn-sm btn-warning">
                <span data-feather="arrow-left"></span>
                Voltar
            </a>

            <?php
        } else {
            //nao deu certo, erro

            $errorArray = $stmt_servico->errorInfo();
            ?>
            <div class="alert alert-danger" role="alert">
                <h4>Falha ao cadastrar dados</h4>
                <p><?= $errorArray[2]; ?></p>
            </div>

            <?php
        }
    }

    require 'rodape.php';

?>