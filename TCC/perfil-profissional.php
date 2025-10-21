<?php
session_start();
require "logica-autenticacao.php";
require "Conexao.php";

if (!isset($_GET["id"]) || empty($_GET["id"])) {
    echo "<p class='alert alert-danger'>Profissional não especificado.</p>";
    exit;
}

$id = intval($_GET["id"]);

// Consulta os dados do profissional
$sqlProfissional = "SELECT u.nome, p.descricao, p.rede_social, p.telefone
            FROM profissionais p
            JOIN usuarios u ON p.id_usuario = u.id
            WHERE p.id = ?";
$stmtProfissional = $conn->prepare($sqlProfissional);
$stmtProfissional->execute([$id]);
$profissional = $stmtProfissional->fetch();

if (!$profissional) {
    echo "<p class='alert alert-danger'>Profissional não encontrado.</p>";
    exit;
}

// Consulta os serviços oferecidos
$sqlServico = "SELECT s.id, s.nome, s.descricao, s.foto_servico
            FROM servicos s
            JOIN servico_profissional sp ON s.id = sp.id_servico
            WHERE sp.id_profissional = ? ";

$stmtServico = $conn->prepare($sqlServico);
$stmtServico->execute([$id]);
$servicos = $stmtServico->fetchAll();

$titulo_pagina = "PERFIL DE " . mb_strtoupper($profissional["nome"]);
require 'cabecalho.php';
?>

<div class="container py-4 bg-light">
    <h2>Perfil do Profissional</h2>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <p><b>Nome:</b> <?= $profissional["nome"] ?></p>
            <p><b>Descrição:</b> <?= $profissional["descricao"] ?></p>
            <p><b>Telefone:</b> <?= $profissional["telefone"] ?></p>
        </div>
        <div class="col-md-6">
            <p><b>Rede Social:</b> <?= $profissional["rede_social"] ?></p>
        </div>
    </div>

    <hr>
    <h4 class="mt-4">Serviços oferecidos</h4><br>

    <?php 
        if (count($servicos) > 0){
            ?>
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
                    <?php 
                    foreach($servicos as $s){
                    ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $s["nome"] ?></h5><br>
                                    <img src= "img/<?= $s["foto_servico"] ?>" class="img-fluid mb-3" alt="foto_servico"><br>
                                    <hr>
                                    <h6 class="card-text"><?= $s["descricao"] ?></h6>
                                </div>
                            </div>
                        </div>
                    <?php 
                    }
                    ?>
                </div><br>
            <?php
        } else {
        ?>
            <p class="alert alert-warning">Nenhum serviço cadastrado por este profissional.</p>

            <a href="listagem-profissionais.php" class="btn btn-sm btn-warning">
                <span data-feather="arrow-left"></span>
                Voltar
            </a>
            
        <?php 
        }
    ?>
    
</div>


<?php 
require 'rodape.php'
?>
