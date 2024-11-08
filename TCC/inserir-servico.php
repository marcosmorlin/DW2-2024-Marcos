<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Pagina de inserção de Servicos";
require 'cabecalho.php';

require 'Conexao.php';  

$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);

echo "<p><b>Nome:</b> $nome</p>";
echo "<p><b>descricao:</b> $descricao</p>";

$sql = "INSERT INTO servicos(id, nome, descricao) 
            VALUES (?, ?, ?)";
            

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id, $nome, $descricao]);

if($result == true){
    //deu certo insert
    ?>
    <div class="alert alert-success" role="alert">
        <h4>Dados gravados sucesso</h4>
    </div>

    <?php
} else {
    //nao deu certo, erro
    $errorArray = $stmt->errorInfo();
    ?>
    <div class="alert alert-danger" role="alert">
        <h4>Falha ao efetuar gravação</h4>
        <p><?=$errorArray[2]; ?></p>
    </div>

    <?php
}
require 'rodape.php'

?>