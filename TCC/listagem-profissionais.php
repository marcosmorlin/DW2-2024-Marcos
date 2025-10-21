<style>
    .link-small {
        font-size: 0.8em;
    }
</style>

<?php
session_start();
require "logica-autenticacao.php";

/*Tratamento de permissões
if (!autenticado() || !isAdmin()) {
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}
*/

$titulo_pagina = "Procurar Profissionais";
require 'cabecalho.php';
require 'Conexao.php';

if (isset($_GET["ordem"]) && !empty($_GET["ordem"])) {
    $ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $ordem = "u.nome";
}

if (isset($_POST["busca"]) && !empty($_POST["busca"])) {
    $busca = filter_input(INPUT_POST, "busca", FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo_busca = filter_input(INPUT_POST, "tipo_busca", FILTER_SANITIZE_SPECIAL_CHARS);
    $buscaOriginal = $busca;

    $sql = "SELECT  p.id as profissional_id,
                    u.nome as profissional_nome,
                    p.descricao 
            FROM profissionais p
            JOIN usuarios u ON p.id_usuario = u.id
            WHERE u.nome LIKE ? OR 
                p.descricao LIKE ?
            ORDER BY $ordem";

    $busca = '%' . str_replace(' ', '%', $busca) . '%';
    $stmt = $conn->prepare($sql);
    $stmt->execute([$busca, $busca]);
    $profissionais = $stmt->fetchAll();
} else {
    $busca = null;
    $buscaOriginal = null;

    $sql = "SELECT p.id as profissional_id, u.nome as profissional_nome, p.descricao
            FROM profissionais p
            JOIN usuarios u ON p.id_usuario = u.id
            ORDER BY $ordem";

    $stmt = $conn->query($sql);
    $profissionais = $stmt->fetchAll();
}
?>

<!--<div class="row">
    <div class="col">
        <form class="row" role="search" method="post" action="?ordem=<?= $ordem ?>">
            <div class="col-sm-6">
                <input class="form-control me-2" type="search" name="busca" id="busca"
                       placeholder="Digite aqui..." aria-label="Search">
            </div>
            <div class="col-sm-2">
                <button style="background-color: #2d5986; color: white;" class="btn btn-primary" type="submit">
                    <i data-feather="search"></i><span class="px-2">Pesquisar</span>
                </button>
            </div>
        </form>
    </div>
</div>-->

<?php if (!empty($buscaOriginal)): ?>
    <div class="row">
        <div class="col">
            <div class="alert alert-light mb-0 fs-4" role="alert">
                Você está buscando por: "<mark class="fst-italic"><?= $buscaOriginal ?></mark>",
                <a class="link-small" href="?ordem=<?= $ordem ?>">Limpar</a>
            </div>
        </div>
    </div>
<?php endif; ?>

<hr>

<div class="album py-5 bg-light">
    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php
            $resultados = count($profissionais);
            for($i = 0; $i < $resultados; $i++){
                $row = $profissionais[$i];
                ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row["profissional_nome"] ?></h5>
                                <hr class="mt-0 mb-2">
                                <p class="card-text"><b>Descrição/Serviços:</b> <?= $row["descricao"] ?></p><br>
                                <a href="perfil-profissional.php?id=<?= $row["profissional_id"] ?>" class="btn btn-primary btn-sm">
                                    Ver perfil
                                </a>

                            <!--<?php 
                                    if (autenticado()){
                                        ?>
                                        <div class="mt-3">
                                            <a class="btn btn-sm btn-warning"
                                            href="formulario-alterar-profissional.php?id=<?= $row["profissional_id"] ?>">
                                                <span data-feather="edit"></span>Alterar
                                            </a>
                                            <a class="btn btn-sm btn-danger"
                                            href="excluir-profissional.php?id=<?= $row["profissional_id"] ?>"
                                            onclick="return confirm('Tem certeza que deseja excluir este profissional?');">
                                                <span data-feather="trash-2"></span>Excluir
                                            </a>
                                        </div>
                                        <?php
                                    }        
                                ?>-->
                            </div>
                        </div>
                    </div>
                <?php 
            }
            ?>

            <?php 
                if ($resultados === 0 && !empty($buscaOriginal)){
                    ?>
                        <div class="col mt-2">
                            <div>
                                <p class="alert alert-light fs-6">Nenhum profissional encontrado</p>
                                <a href="listagem-profissionais.php">Ver todos</a>
                            </div>
                        </div>
                    <?php
                } 
            ?>
        </div>
    </div>
</div>

<?php 
require 'rodape.php' 
?>
