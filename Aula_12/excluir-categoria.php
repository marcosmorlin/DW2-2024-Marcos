<?php

session_start();
require "logica-autenticacao.php";

/** Tratamento de permissoes */
if(!autenticado() || !isAdmin()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}   
/** Tratamento de permissoes */
require 'Conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

$sql= "DELETE FROM categorias WHERE id = ?" ;

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id]);

} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

$count = $stmt->rowCount();

if($result == true && $count >= 1){
    
    $_SESSION["result"] = true;
    $_SESSION["mensagem_sucesso"] = "Registro excluido com sucesso";
    
} else {

    if(stripos($error, "fk_produtos_categoria") != false){
        $error = "Atenção: Não é possivel excluir essa categoria pois há produtos que a utilizam."; 
    }

    $_SESSION["result"] = false;
    $_SESSION["mensagem_erro"] = "Falha ao efetuar exclusão";
    $_SESSION["erro"] = $error;
}

redireciona("formulario-categorias.php");

?>