<style>
    .card {
        border-radius: 10px;
        background: #fff;
        /* Fundo branco */
        padding: 20px;
    }

    button{
        border-radius: 50px;
    }
</style>

<?php

session_start();
require "logica-autenticacao.php";

if (autenticado()) {
    redireciona();
    die();
}


$titulo_pagina = "";
require 'cabecalho.php'

    ?>

<section class="gradient-custom">
    <div class="row">
        <div class="col-4 offset-4">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h1 class="h3 mb-3 ">Por favor, identifique-se</h1>
                    <form action="login.php" method="post">
                        <div class="form-floating mb-2">
                            <input type="email" name="email" class="form-control" id="floatingInput"
                                placeholder="name@example.com" required>
                            <label for="floatingInput">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" name="senha" class="form-control" id="floatingPassword"
                                placeholder="Senha" required>
                            <label for="floatingPassword">Senha</label>
                        </div>
                        <button class="btn btn-primary w-100 py-2" type="submit">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="row">
    <div class="col-4 offset-4">
        <?php
        if (isset($_SESSION["result_login"])) {

            if ($_SESSION["result_login"]) {
                //se login deu certo
                ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Autenticado com sucesso!</h4>
                </div>
                <?php
            } else {
                $erro = $_SESSION["erro"];
                unset($_SESSION["erro"]);
                ?>
                <br>
                <div class="alert alert-danger" role="alert">
                    <h5 class="alert-heading">Erro ao se autenticar.</h5>
                    <p><?php echo $erro ?></p>
                </div>
                <?php
            }
            unset($_SESSION["result_login"]);
        }
        ?>
    </div>
</div>

<?php

require 'rodape.php'

    ?>