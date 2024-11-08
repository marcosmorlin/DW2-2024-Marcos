<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Inicio";
require 'cabecalho.php';


?>

    <p class="display-5">
        Seja bem vindo a aplicação <strong>"ServiçoZ"</strong>.
    </p>
    <p class="display-5">
        Esta é a página inicial.
    </p>
    <hr>
    
<?php

    if(isset($_SESSION["restrito"]) && $_SESSION["restrito"]){
    ?>
        <div class="alert alert-danger" role="alert">
            <h4>Esta é uma pagina PROTEGIDA!!!</h4>
            <p>Voce esta tentando acessar conteudo restrito</p>
        </div>
    <?php
        unset($_SESSION["restrito"]);
    }

require 'rodape.php';

?>