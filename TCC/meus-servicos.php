<?php
session_start();
require("logica-autenticacao.php");

/*Tratamento de permissoes 
if(!autenticado() || !isAdmin()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}   
Tratamento de permissoes */

$titulo_pagina = "Meus Serviços";
require("cabecalho.php");

require("Conexao.php");

//consulta de servicos, juncao tabelas (servico_profissional e servicos)
$id_profissional = $_SESSION['id_profissional'];

$sql = "SELECT s.id as servico_id, 
                s.nome as servico_nome,
                s.descricao as servico_descricao,
                s.foto_servico as servico_foto
        FROM servico_profissional sp
        JOIN servicos s ON sp.id_servico = s.id
        WHERE sp.id_profissional = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_profissional]);

?>

<div class="album py-5 bg-light">
    <div class="mb-4 ms-4">
        <a href="cadastro-servicos.php" class="btn btn-info me-2">
        <span data-feather="plus"></span>
            Novo serviço
        </a>
    </div>
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g3">
            <?php
            while($row = $stmt->fetch()){

            ?>
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5><b><?= $row["servico_nome"] ?></b></h5> <br>
                        
                        <img src="img/<?= $row["servico_foto"] ?>" alt="foto" class="img-fluid mb-3"><br>
                        
                        <p class="card-text mb-2"><b>Descricao:</b> <br><?= $row["servico_descricao"] ?></p>
                        <!--<hr class="mt-0 mb-2"><br>
                                <p class="card-text"></p>-->
                        <hr class="mt-0 mb-2">
                        <p class="card-text text-end">ID: <b><?= $row["servico_id"] ?></b></p>

                        <?php
                        if (autenticado()) {
                            ?>
                            <td class="text-end">
                                <a class="btn btn-sm btn-warning"
                                    href="formulario-alterar-servicos.php?id=<?= $row["servico_id"] ?>">
                                    <span data-feather="edit"></span>
                                    Editar
                                </a>
                            </td>

                            <td class="text-end">
                                <a class="btn btn-sm btn-danger" href="excluir-servico.php?id=<?= $row["servico_id"] ?>"
                                    onclick="if(!confirm('Tem certeza que deseja excluir o serviço ?')) return false;">
                                    <span data-feather="trash-2"></span>
                                    Excluir
                                </a>
                            </td>

                            <?php
                        }
                        ?>
                    </div>
                </div><br>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<?php

require("rodape.php");

?>