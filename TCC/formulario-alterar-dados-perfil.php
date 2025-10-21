<?php

    session_start();
    require "logica-autenticacao.php";

    $titulo_pagina = "Alterar Dados do Perfil";
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

    $sqlUsuario = "SELECT id, nome, email FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sqlUsuario);
    $result = $stmt->execute([$id]);
    $usuario = $stmt->fetch();

    $sqlProfissional = "SELECT telefone, descricao, rede_social FROM profissionais WHERE id_usuario = ?";
    $stmt = $conn->prepare($sqlProfissional);
    $result = $stmt->execute([$id]);
    $profissional = $stmt->fetch();


?>


    <form action="alterar-dados-perfil.php"  method="Post"> 

        <input type="hidden" name="id" id="id" value="<?= $usuario["id"] ?>">
            
            <div class="col-md-6 mb-3">
                <label for="text">Nome:</label>
                <input type="text" class="form-control" name="nome" value="<?= $usuario["nome"] ?>" >
            </div>

            <div class="col-md-6 mb-3">
                <label for="text">E-mail:</label>
                <input type="text" class="form-control" name="email" value="<?= $usuario["email"] ?>" >
            </div>

            <?php
                if ($profissional) {
                    ?>

                        <div class="col-md-6 mb-3">
                            <label for="phone">Telefone:</label>
                            <input type="phone" class="form-control"name="telefone" value="<?= $profissional["telefone"] ?>" >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="text">Rede Social:</label>
                            <input type="text" class="form-control" name="rede_social" value="<?= $profissional["rede_social"] ?>" >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="text">Descrição:</label>
                            <textarea id="descrição" class="form-control" name="descricao" ><?= $profissional["descricao"] ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <button type="submit" class="btn btn-success mt-4">
                                Alterar
                                <span data-feather="check"></span>
                            </button>
                        </div>
                        
                    <?php
                } 
            ?>
    </form>

<?php
require 'rodape.php'
?>