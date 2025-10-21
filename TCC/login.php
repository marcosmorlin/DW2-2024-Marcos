<?php

session_start();
require 'logica-autenticacao.php';

require 'Conexao.php';

$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_SPECIAL_CHARS);

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


if (/*usuario existe*/ $row) {
    if(password_verify( $senha,$row['senha'])){
        //deu certo a senha

        $_SESSION["email"] = $email;
        $_SESSION["nome"] = $row['nome'];
        $_SESSION["idUsuario"] = $row['id'];

        //verificar se user é profissional 
        $sql = "SELECT id FROM profissionais WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION["idUsuario"]]);

        //se for, salva na session
        if($profissional = $stmt->fetch()){
            $_SESSION["id_profissional"] = $profissional["id"];
        } else {
            unset($_SESSION["id_profissional"]);
        }

        $_SESSION["result_login"] = true;
        
    } else {
        //nao deu certo, senha errada
        unset($_SESSION["email"]);
        unset($_SESSION["nome"]);
        unset($_SESSION["id_profissional"]);
        unset($_SESSION["nome"]);
        unset($_SESSION["tipoUser"]);

        $_SESSION["result_login"] = false;
        $_SESSION["erro"] = "A <b>Senha</b> está incorreta.";

        
    } 
} else{
    //nao deu certo, usuario existe/incorreto

    unset($_SESSION["email"]);
    unset($_SESSION["nome"]);
    unset($_SESSION["id_profissional"]);
    
    $_SESSION["result_login"] = false;
    $_SESSION["erro"] = "O <b>E-Mail</b> está incorreto.";
}

   
//require 'rodape.php'
redireciona("form-login.php");
?>