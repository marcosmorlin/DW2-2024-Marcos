<?php

session_start();
require 'logica-autenticacao.php';

/*
$titulo_pagina = "página de inserção de produtos";
require 'cabeçalho.php';
*/

require 'Conexao.php';

$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, "senha");

//$senha_hash = password_hash($senha, PASSWORD_BCRYPT); 

/*
echo "<p><b>nome:</b> $nome</p>";
echo "<p><b>E-mail:</b> $email</p>";
echo "<p><b>Senha Hash:</b> $senha</p>";
*/

$sql= "INSERT INTO usuarios(nome, email, senha) 
            VALUES (?, ?, crypt(?, gen_salt('bf', 8) ))";

            // crypt(?, gen_salt('bf', 8) )
            
try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$nome, $email, $senha]);

} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

if($result == true){
    //deu certo insert
    $_SESSION["result"] = true;
} else {
    //tratamento de mensagem de erro
    if(stripos($error, "duplicate key") != false){
        $error = "Atenção: o email <b>\"$email\"</b> já está registrado. <b></b>$error"; 
    }
    $_SESSION["result"] = false;
    $_SESSION["erro"] = $error;
}
redireciona("formulario-usuarios.php");

?>