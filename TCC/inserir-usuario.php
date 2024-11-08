<?php
session_start();
require 'logica-autenticacao.php';

require 'Conexao.php';  

$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, "senha");

/*
$senha_hash = password_hash($senha, PASSWORD_BCRYPT); 

echo "<p><b>Nome:</b> $nome</p>";
echo "<p><b>Email:</b> $email</p>";
echo "<p><b>senha hash:</b> $senha_hash</p>";
*/

$sql = "INSERT INTO usuarios(nome, email, senha) 
            VALUES (?, ?, ?)";
           
            
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
    //nao deu certo, erro
    //tratamento de mensagem de erro
    if(stripos($error, "duplicate key") != false){
        $error = "Atenção: o email <b>\"$email\"</b> já está registrado. <b></b>$error"; 
    }
    $_SESSION["result"] = false;
    $_SESSION["erro"] = $error;
}
redireciona("formulario-usuarios.php");

?>