<?php

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<?php

session_start();
require "logica-autenticacao.php";

if (!autenticado()) {
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}

$titulo_pagina = "Formulário de Cadastro de Profissionais";
require 'cabecalho.php';

?>

<div class="container-fluid text-center ">
    <div class="card shadow-lg">
        <div class="card-header bg-secondary text-white">
            <h2>Cadastro de Profissional</h2>
        </div>
        <div class="card-body">
            <form action="inserir-profissional.php" method="Post">
          
                    <!-- Coluna Dados do Profissional -->
                <div class="row justify-content-center">
                    <p class="alert alert-info col-md-6"><i class='bi bi-info-circle-fill'></i> Para cadastrar seus serviços, preencha os dados abaixo</p>
                    <div class="col-md-7">
                        <h3 class="mb-4">Dados do Profissional</h3>
                        <div class="mb-4">
                            <label for="phone" class="form-label">Telefone:</label>
                            <input type="tel" class="form-control" pattern="\([0-9]{2}\)\s[0-9]{4,5}-[0-9]{4}" placeholder="(XX) XXXX-XXXX" id="phone" name="telefone" required>
                        </div>
                        <div class="mb-4">
                            <label for="rede_social" class="form-label">Rede Social:</label>
                            <input type="text" class="form-control" id="rede_social" name="rede_social">
                        </div>
                        <div class="mb-4">
                            <label for="descricao" class="form-label">Descrição/biografia:</label>
                            <textarea class="form-control" name="descricao" id="descricao" rows="5"></textarea>
                        </div>
                    </div>
                </div>
            

                <!-- Botões -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-success me-2">Salvar</button>
                    <button type="reset" class="btn btn-danger me-2">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php

require 'rodape.php';

?>
