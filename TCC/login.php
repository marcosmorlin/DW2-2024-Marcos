<?php

session_start();
require 'logica-autenticacao.php';

$titulo_pagina = "Pagina destino da autenticação(LOGIN)";
require 'cabecalho.php';

require 'Conexao.php';


$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_SPECIAL_CHARS);

echo "<p><b>Nome:</b> $email</p>";

$sql = "SELECT id, nome, senha FROM usuarios WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$email]);
$row = $stmt->fetch();

if(password_verify($senha, $row['senha'])){
    //deu certo

    $_SESSION["email"] = $email;
    $_SESSION["nome"] = $row['nome'];
    $_SESSION["idUsuario"] = $row['id'];

?>
    <div class="alert alert-success" role="alert">
        <h4>Autenticado com sucesso</h4>
    </div>

<?php

    
} else {
    //nao deu certo, erro
    unset($_SESSION["email"]);
    unset($_SESSION["nome"]);

    ?><br>
    
    <div class="alert alert-danger" role="alert">
        <h4>Falha ao efetuar atenticação</h4>
        <p>Usuario ou senha incorretos</p>
    </div>

    <?php
}
require 'rodape.php'

?>