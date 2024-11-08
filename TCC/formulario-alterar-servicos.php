<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Formulario de alteração de Servicos";
require 'cabecalho.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);

if(empty($id)){
    ?>
    
        <div class="alert alert-danger" role="alert">
            <h4>Falha ao abrir formulário para edição</h4>
            <p>ID do produto está vazio.</p>
        </div>
    <?php
        exit;
    }

require 'Conexao.php';

$sql= "SELECT nome, descricao FROM servicos WHERE id = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id]);

$rowServico = $stmt->fetch();

//var_dump($rowServico);
?>
    <form action="alterar-servico.php"  method="Post"> 
        <input type="hidden" name="id" id="id" value="<?= $id?>">
        <div class="row">
            <div class="col-8">
                <div class="mb-3 row">
                    <div class="col-8">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" 
                        id="nome" name="nome" required
                        value="<?=$rowServico['nome']?>">
                    </div>
                    
                    
                </div>
        
                <div class="mb-3">
                    <label class="form-label" for="descricao">
                        Descrição do Serviço:
                    </label>
                    <textarea class="form-control" name="descricao" id="descricao"><?=$rowServico['descricao']?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Gravar</button>
                <button type="reset" class="btn btn-warning">Cancelar</button>
            </div>
        </div>
    </form>

<?php

require 'rodape.php'

?>