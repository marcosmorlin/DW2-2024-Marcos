<?php

session_start();
require "logica_autenticacao.php";




$titulo_pagina = "Cadastro de serviços";
require 'cabeçalho.php';

?>

    <form action="formulario-produto.php"  method="Post"> 

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
                        Descrição do produto
                    </label>
                    <textarea class="form-control" name="descricao" id="descricao"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Gravar</button>
                <button type="reset" class="btn btn-warning">Cancelar</button>
            </div>
        </div>
    </form>

<?php

require 'rodapé.php'

?>