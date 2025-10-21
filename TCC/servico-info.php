<?php
session_start();
require "logica-autenticacao.php";
require "Conexao.php";

if (!isset($_GET["id_servico"]) || empty($_GET["id_servico"])) {
    echo "<p class='alert alert-danger'>Servico não especificado.</p>";
    exit;
}

$id_servico = intval($_GET["id_servico"]);

// Consulta os serviços oferecidos
$sql = "SELECT s.id, s.nome, s.descricao, s.foto_servico,
                p.id as id_profissional,
                p.descricao as descricao_profissional,
                u.nome as profissional_nome
            FROM servicos s 
            JOIN servico_profissional sp ON s.id = sp.id_servico
            JOIN profissionais p ON sp.id_profissional = p.id
            JOIN usuarios u ON p.id_usuario = u.id
            WHERE s.id = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$id_servico]);
$servico = $stmt->fetch();

if (!$servico) {
    echo "<p class='alert alert-danger'>Servico não encontrado.</p>";
    exit;
}


$titulo_pagina = "INFORMAÇÕES DO SERVIÇO";
require 'cabecalho.php';
?>

<div class="container py-4 bg-light">
    <?php 
    if ($servico) {
    ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <?php 
            ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= $servico["nome"] ?></h5><br>
                            <img src= "img/<?= $servico["foto_servico"] ?>" class="img-fluid mb-3" alt="foto_servico">
                            <p class="card-text"><?= $servico["descricao"] ?></p>
                            <hr>
                            
                            <h6>Sobre o profissional:</h6>
                            <p class="card-text"><b>Nome:</b> <?= $servico["profissional_nome"]?></b></p>
                            <p class="card-text"><b>Descricao:</b> <?= $servico["descricao_profissional"] ?></p>

                            <a href="perfil-profissional.php?id=<?= $servico["id_profissional"] ?>">
                                Ver perfil do profissional
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
            ?>
        </div><br>
    
        <a href="listagem-servicos-cards.php" class="btn btn-sm btn-warning">
            <span data-feather="arrow-left"></span>
            Voltar
        </a>
        
    <?php
    } else {
    ?>
        <p class="alert alert-warning">Nenhum serviço cadastrado por este profissional.</p>

    <?php
    }
    ?>
</div>


<?php 
require 'rodape.php'
?>
