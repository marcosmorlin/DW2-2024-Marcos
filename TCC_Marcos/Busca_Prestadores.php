<?php

session_start();
require "logica_autenticacao.php";





$titulo_pagina = "Procura por profissionais";
require 'cabeçalho.php';

?>

    <form action="Busca_Prestadores.php" method="POST">
            <div class="row">
                <div class="col-8">
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                    </div>
                        
                    <div class="mb-3">
                        <label class="form-label" for="descricao">
                            Descrição do serviço:
                        </label>
                        <textarea class="form-control" name="descricao" id="descricao"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Gravar</button>
                    <button type="reset" class="btn btn-warning">Cancelar</button>
                </div>
                <div class="col-3">
                    <img src="" 
                    alt="-" class="img-thumbnail" id="image-preview" style="display: none;">
                </div>
            </div>
    </form>

<?php

require 'rodapé.php'

?>