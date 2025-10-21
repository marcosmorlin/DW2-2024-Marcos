<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Alteração de Dados";
require 'cabecalho.php';

require 'Conexao.php';  

$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$telefone = filter_input(INPUT_POST, "telefone", FILTER_SANITIZE_NUMBER_INT);
$rede_social = filter_input(INPUT_POST, "rede_social", FILTER_SANITIZE_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);

echo "<p><b>ID:</b> $id</p>";
echo "<p><b>Nome:</b> $nome</p>";
echo "<p><b>email:</b> $email</p>";

$profissional = null;

$consultaProfissional = "SELECT * FROM profissionais WHERE id_usuario = ? ";
$stmtConsulta = $conn->prepare($consultaProfissional);
$stmtConsulta->execute([$id]);
$profissional = $stmtConsulta->fetch();

if($profissional){

    echo "<p><b>telefone:</b> $telefone</p>";
    echo "<p><b>rede_social:</b> $rede_social</p>";
    echo "<p><b>descricao:</b> $descricao</p>";

} else {

    echo "<p><b>telefone:</b> <span class='text alert-info d-inline-block'>NULL</p>";
    echo "<p><b>rede_social:</b> <span class='text alert-info d-inline-block'>NULL</p>";
    echo "<p><b>descricao:</b> <span class='text alert-info d-inline-block'>NULL</p>";
}


$sqlUsuario = "UPDATE usuarios SET nome = ?, email = ?
            WHERE id = ?";
            
$stmtUsuario = $conn->prepare($sqlUsuario);
$resultUsuario = $stmtUsuario->execute([$nome, $email, $id]);
$countUsuario = $stmtUsuario->rowCount();


 

$sqlProfissional = "UPDATE profissionais SET telefone = ?, rede_social = ?, descricao = ?
            WHERE id_usuario = ?";
            
$stmtProfissional = $conn->prepare($sqlProfissional);
$resultProfissional = $stmtProfissional->execute([$telefone, $rede_social, $descricao , $id]);
$countProfissional = $stmtProfissional->rowCount();



if($resultUsuario == true && $countUsuario >= 1 || $resultProfissional == true && $countProfissional >= 1){
    //deu certo insert
    ?>
        <div class="alert alert-success" role="alert">
            <h4>Dados alterados com sucesso</h4>
        </div>
        
        <p>
            <a href="perfil-geral.php?email=<?= urldecode($email) ?>" class="btn btn-sm btn-warning">
                <span data-feather="arrow-left"></span>
                Voltar
            </a>
        </p>
    <?php
    
    $_SESSION["email"] = $email;
    $_SESSION["nome"] = $nome;

}  elseif (($resultUsuario == true && $countUsuario == 0) || ($resultProfissional == true && $countProfissional == 0)) {
    
    ?> 
        <div class="alert alert-secondary" role="alert">
            <h4>Nenhum dado foi alterado</h4>
        </div>
    <?php

} else {
    
    //nao deu certo, erro
    if($resultUsuario == false){

        $errorArray = $stmtUsuario->errorInfo();

    } elseif ($resultProfissional == false) {
        
        $errorArray = $stmtProfissional->errorInfo();

    } else {

        $errorArray = ["", "", "Erro desconhecido"];
    }

    ?>
    <div class="alert alert-danger" role="alert">
        <h4>Falha ao efetuar alteração</h4>
        <p><?=$errorArray[2]; ?></p>
    </div>

    <?php
}
require 'rodape.php'

?>