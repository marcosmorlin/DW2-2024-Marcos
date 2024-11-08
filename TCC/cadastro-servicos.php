<?php

session_start();
require "logica-autenticacao.php";

if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}

$titulo_pagina = "Formulario de cadastro de Servicos";
require 'cabecalho.php'

?>


    <form action="inserir-servico.php"  method="Post"> 

        <div class="row">
            <div class="col-8">
                <div class="mb-3 row">
                    <div class="col-8">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    
                    
                </div>
        
                <div class="mb-3">
                    <label class="form-label" for="descricao">
                        Descrição do Serviço:
                    </label>
                    <textarea class="form-control" name="descricao" id="descricao"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Gravar</button>
                <button type="reset" class="btn btn-warning">Cancelar</button>
            </div>
        </div>
    </form>

<?php

require 'rodape.php'

?>