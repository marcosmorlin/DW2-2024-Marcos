<?php

session_start();
require 'logica-autenticacao.php';

/** Tratamento de permissoes */
if(!autenticado() || !isAdmin()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}   
/** Tratamento de permissoes */
/*
$titulo_pagina = "página de inserção de produtos";
require 'cabeçalho.php';
*/

require 'Conexao.php';

$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);

$sql= "UPDATE categorias SET nome = ? WHERE id = ?";

            // crypt(?, gen_salt('bf', 8) )
            
try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$nome, $id]);

} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

if($result == true){
    //deu certo insert
    $_SESSION["result"] = true;
    $_SESSION["mensagem_sucesso"] = "Dados alterados com sucesso";
} else {
    //tratamento de mensagem de erro
    $_SESSION["result"] = false;
    $_SESSION["mensagem_erro"] = "Falha ao efetuar alteração";
    $_SESSION["erro"] = $error;
}
redireciona("formulario-categorias.php");

?>