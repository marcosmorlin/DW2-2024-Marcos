<?php
session_start();
require 'logica-autenticacao.php';

require 'Conexao.php';  

$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, "senha");

$senha_hash = password_hash($senha, PASSWORD_BCRYPT); 


$sql = "INSERT INTO usuarios(nome, email, senha) 
            VALUES (?, ?, ?)";
           

try {
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([$nome, $email, $senha_hash]);

} catch (Exception $e) {
    $result = false;
    $error = $e->getMessage();
}
            
if($result == true){
    //deu certo insert
    $_SESSION["result"] = true;
} else {
    //nao deu certo, erro
    //tratamento de mensagem de erro
    if(stripos($error, "Duplicate entry") != false){
        $error = "Atenção: o email <b>\"$email\"</b> já está registrado. <br><br>$error"; 
    }
    $_SESSION["result"] = false;
    $_SESSION["erro"] = $error;
}
redireciona("formulario-usuarios.php");

?>