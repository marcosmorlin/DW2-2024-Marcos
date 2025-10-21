<?php

session_start();
require "logica-autenticacao.php";

if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}

require 'Conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

//id_usuario() => id de quem esta autenticado 

if(id_usuario() != $id && !isAdmin()){
    $_SESSION["result"] = false;
    $_SESSION["erro"] = "Operacao nao permitida";
    redireciona("listagem-usuarios.php");
    die();
}

//echo "<p><b>ID:</b> $id</p>";

$sql= "DELETE FROM usuarios WHERE id = ?" ;

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$id]);

} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

$count = $stmt->rowCount();

if($result == true && $count >= 1){
    
    if(isAdmin()){

        redireciona("listagem-usuarios.php");
        
    } else {

    redireciona("sair.php");

    }

    die();

} elseif($count == 0){

    $_SESSION["result"] = false;
    $_SESSION["erro"] = "Não foi encotrado nenhum registro com o ID ($id)";
    redireciona("listagem-usuarios.php");
    die();
    
} else {

    $_SESSION["result"] = false;
    $_SESSION["erro"] = $error;
    redireciona("listagem-usuarios.php");
    die();
    
}

?>