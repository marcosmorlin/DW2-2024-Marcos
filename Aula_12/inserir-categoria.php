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

$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);

$sql= "INSERT INTO categorias(nome) VALUES (?)";

            // crypt(?, gen_salt('bf', 8) )
            
try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$nome]);

} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

if($result == true){
    //deu certo insert
    $_SESSION["result"] = true;
    $_SESSION["mensagem_sucesso"] = "Dados gravados com sucesso";
} else {
    //tratamento de mensagem de erro
    $_SESSION["result"] = false;
    $_SESSION["mensagem_erro"] = "Falha ao efetuar gravação";
    $_SESSION["erro"] = $error;
}
redireciona("formulario-categorias.php");

?>