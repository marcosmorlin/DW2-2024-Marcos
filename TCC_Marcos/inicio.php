<?php

session_start();
require "logica_autenticacao.php";

$titulo_pagina = "Inicio";
require 'cabeçalho.php';

require "Conexao.php";

/*
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
*/

?>

    <p class="display-4">
        Seja bem vindo a aplicação <strong>"Serviçoz"</strong>.
    </p>
    <p class="display-4">
        Esta é a página inicial.
    </p>
    <hr>
    <h4>Teste conexao</h4>
<?php

/*if(isset($_SESSION["restrito"]) && $_SESSION["restrito"]){
    ?>
    <div class="alert alert-danger" role="alert">
        <h4>Esta é uma pagina PROTEGIDA!!!</h4>
        <p>Voce esta tentando acessar conteudo restrito</p>
    </div>
    <?php
        unset($_SESSION["restrito"]);
}*/

require 'rodapé.php';

?>