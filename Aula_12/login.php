<?php
session_start();
require "logica-autenticacao.php";

/*
$titulo_pagina = "página destino da autenticação(LOGIN)";
require 'cabeçalho.php';
*/

require 'Conexao.php';

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_SPECIAL_CHARS);

//echo "<p><b>Email:</b> $email</p>";

// verifica se tem algum admin com esse email
// tem q ser primeiro, pq tem maior prioridade/maior grau de permissões
$sql = "SELECT id, nome, senha FROM administradores WHERE email = ?";

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$email]);
    $_SESSION["tipoUser"] = "admin";

} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}

$count = $stmt->rowCount();

// nao achou admin com esse email
if($count == 0){

    $sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";
    try {
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$email]);
        $_SESSION["tipoUser"] = "usuario";
    
    } catch (Exception $e) {
        $result = false;
        $error = $e->getMessage();
    }

}

$row = $stmt->fetch();

if(password_verify($senha, $row['senha'])){
    //deu certo

    $_SESSION["email"] = $email;
    $_SESSION["nome"] = $row['nome'];
    $_SESSION["idUsuario"] = $row['id'];
    $_SESSION["result_login"] = true;

} else {
     //nao deu certo

     unset( $_SESSION["email"]);
     unset( $_SESSION["nome"]);
     unset( $_SESSION["tipoUser"]);

     $_SESSION["result_login"] = false;
     $_SESSION["erro"] = "Usuario ou senha incorretos.";
     
}
//require 'rodape.php'
redireciona("form-login.php");
?>