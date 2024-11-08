<?php

session_start();
require "logica-autenticacao.php";

if(autenticado()){
    redireciona();
    die();
}


$titulo_pagina = "";
require 'cabecalho.php'

?>

<div class="row">
    <div class="col-4 offset-4">
        <form action="login.php"  method="Post"> 

            <h1 class="h3 mb-3 fw-normal">Por favor Identifique-se</h1>

                <div class="form-floating mb-2">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                    <label for="floatingInput">Email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="senha" class="form-control" id="floatingPassword" placeholder="Senha" required>
                    <label for="floatingPassword">Senha</label>
                </div>

                <button class="btn btn-secondary w-100 py-2" type="submit">Entrar</button>
        </form>
    </div>
</div>

<?php

require 'rodape.php'

?>