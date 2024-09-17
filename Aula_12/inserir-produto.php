<?php

session_start();
require 'logica-autenticacao.php';

$titulo_pagina = "página de inserção de produtos";
require 'cabeçalho.php';

require 'Conexao.php';

$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$urlfoto = filter_input(INPUT_POST, "urlfoto", FILTER_SANITIZE_URL);
$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
$categoria = filter_input(INPUT_POST, "categoria", FILTER_SANITIZE_NUMBER_INT);

echo "<p><b>nome:</b> $nome</p>";
echo "<p><b>URL foto:</b> $urlfoto</p>";
echo "<p><b>descricao:</b> $descricao</p>";

$sql= "INSERT INTO produtos(nome, urlfoto, descricao, id_categoria) 
            VALUES (?, ?, ?, ?)";
            
$stmt = $conn->prepare($sql);
$result = $stmt->execute([$nome, $urlfoto, $descricao, $categoria]);

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