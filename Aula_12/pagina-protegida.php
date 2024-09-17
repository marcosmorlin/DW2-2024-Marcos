<?php

session_start();
require "logica-autenticacao.php";

if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}

$titulo_pagina = "Página protegida";
require 'cabeçalho.php';

?>
    <p class="display-5">
        Olá <b><?= nome_usuario(); ?></b>, seja bem-vindo(a)!!!
    </p>
    <div class="text-center">
        <p class="display-4 fw-bold">
            Aula de sessões.
        </p>
        <p class="display-4">
            Esta é uma página <span class="bg-danger text-warning">PROTEGIDA</span>,
        </p>
        <p class="display-4">
            só é possível acessá-la,
        </p>
        <p class="display-4">
            <span class="bg-warning">após ter se autenticado (feito login).</span>
        </p>
    </div>
<?php

require 'rodape.php';

?>