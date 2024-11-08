<?php

session_start();
require "logica_autenticacao.php";





$titulo_pagina = "Formulario de cadastro de profisionais";
require 'cabeçalho.php';

?>

    <form action="cadastro-profissionais.php" method="POST">
            <div class="row">
                <div class="col-8">
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-12">
                            <label for="nome" class="form-label">Endereço:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-5">
                            <label for="nome" class="form-label">Telefone:</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="col-4">
                            <div class="form-inline col-md-10 col-sm-9 col-xs-12">
                                <label class="form-label" for="descricao">
                                    Foto do perfil:
                                </label>
                                <input type="file" class="file-uploader pull-left">
                            
                            </div>
                        </div>
                    </div>
                        
                    <!--<div class="mb-3">
                        <label class="form-label" for="descricao">
                            Descrição do serviço:
                        </label>
                        <textarea class="form-control" name="descricao" id="descricao"></textarea>
                    </div>
                </div>

                </div>-->
                    <button type="submit" class="btn btn-primary">Gravar</button>
                    <button type="reset" class="btn btn-warning">Cancelar</button>
                </div>
                
            </div>
    </form>

<?php

require 'rodapé.php'

?>