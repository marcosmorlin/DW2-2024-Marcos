<?php

session_start();
require "logica_autenticacao.php";

$titulo_pagina = "Listagem de serviços";
require 'cabeçalho.php';

?>

<div class="row">
    <div class="col">

        <form class="row" role="search" method="post" action="?ordem=<?=$ordem?>">

            <label for="tipo_busca" class="fs-5 col-sm-2 col-form-label-sm text-end">
                Buscar por:
            </label>
            <div class="col-sm-2">
                <select name="tipo_busca" id="tipo_busca" class="form-select">
                    <option value="" <?php if(empty($tipo_busca)) echo "selected"; ?>>Todos os campos</option>
                    <option value="id" <?php if($tipo_busca == "id") echo "selected"; ?>>ID</option>
                    <option value="nome" <?php if($tipo_busca == "nome") echo "selected"; ?>>Nome</option>
                    <option value="descr" <?php if($tipo_busca == "descr") echo "selected"; ?>>Descricao</option>
                </select>
            </div>
            <div class="col-sm-6">
                <input class="form-control me-2" type="search" name="busca" id="busca"
                placeholder="Search" aria-label="Search">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" type="submit">
                    <i data-feather="search"></i><span class="px-2">Pesquisar</span>
                </button>
            </div>

        </form>
    </div>
</div>