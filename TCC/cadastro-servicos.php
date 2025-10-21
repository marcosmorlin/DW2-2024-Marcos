<?php

session_start();
require "logica-autenticacao.php";

if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}

$titulo_pagina = "Cadastro de Servicos";
require 'cabecalho.php'

?>


    <form action="inserir-servico.php"  method="Post" enctype="multipart/form-data"> 

        <div class="row">
            <div class="col-7">
                <div class="mb-4 ">
                    <div class="col-12">
                        <label for="nome" class="form-label">Nome do Serviço:</label>
                        <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite aqui..." required>
                    </div>
                    
                </div>
        
                <div class="mb-5">
                    <label class="form-label" for="descricao">
                        Descrição do Serviço:
                    </label>
                    <textarea class="form-control" name="descricao" id="descricao" placeholder="Descreva seu serviço..."></textarea>
                </div>

                <div class="mb-4">
                    <div class="col-sm-7">
                        <label for="foto_servico"> Foto/Imagem do serviço (opcional)</label>
                        <input type="file" class="form-control" id="foto_servico" name="foto_servico" accept="image/* ">
                    </div>
                </div>


                <button type="submit" class="btn btn-success">Salvar</button>
                <button type="reset" class="btn btn-danger">Cancelar</button>

            
            </div>
            <!--<div class="col-3">
                <img src="" alt="-" class="img-thumbnail" id="image-preview" style="display: none;">
            </div>-->
            </div>
        </div>
    </form>

<?php

require 'rodape.php'

?>