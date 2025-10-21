<style>
    .link-small {
        font-size: 0.8em;
    }
</style>
<?php

session_start();
require "logica-autenticacao.php";

/*
if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}*/

$titulo_pagina = "Procurar Serviços";
require 'cabecalho.php';

require 'Conexao.php';

    if (isset($_GET["ordem"]) && !empty($_GET["ordem"])) {
        $ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $ordem = "servico_nome";
    }

    //se tem busca
    if (isset($_POST["busca"]) && !empty($_POST["busca"])) {

        $busca = filter_input(INPUT_POST, "busca", FILTER_SANITIZE_SPECIAL_CHARS);
        $tipo_busca = filter_input(INPUT_POST, "tipo_busca", FILTER_SANITIZE_SPECIAL_CHARS);
        $buscaOriginal = $busca;

        $sql = "SELECT  s.id as servico_id, 
                        s.nome as servico_nome,
                        s.descricao as servico_descricao,
                        s.foto_servico as servico_foto,
                        p.id as profissional_id,
                        u.nome as profissional_nome,
                        u.id as usuario_logado
                    FROM servicos s 
                    LEFT JOIN servico_profissional sp on s.id = sp.id_servico 
                    LEFT JOIN profissionais p on sp.id_profissional = p.id 
                    LEFT JOIN usuarios u on p.id_usuario = u.id
                    WHERE s.id = ? OR
                        s.nome LIKE ? OR
                        s.descricao LIKE ? OR
                        s.foto_servico LIKE ? 
                    ORDER BY $ordem";

        $buscaInt = intval($busca);
        $busca = '%' . $busca . '%';
        $busca = str_replace(' ', '%', $busca);

        $stmt = $conn->prepare($sql);
        $stmt->execute([$buscaInt, $busca, $busca, $busca]);


    } else {

        //se nao tem busca
        $tipo_busca = null;
        $busca = null;

        $sql = "SELECT  s.id as servico_id, 
                        s.nome as servico_nome,
                        s.descricao as servico_descricao,
                        s.foto_servico as servico_foto,
                        u.nome as profissional_nome,
                        p.id as profissional_id,
                        u.id as usuario_logado
                    FROM servicos s 
                    LEFT JOIN servico_profissional sp on s.id = sp.id_servico 
                    LEFT JOIN profissionais p on sp.id_profissional = p.id 
                    LEFT JOIN usuarios u on p.id_usuario = u.id

                    ORDER BY $ordem";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
?>

<div class="row">
    <div class="col">
        <form class="row" role="search" method="post" action="?ordem=<?= $ordem ?>">

            <div class="col-sm-6">
                <input class="form-control me-2" type="search" name="busca" id="busca" placeholder="Digite aqui..."
                    aria-label="Search">
            </div>
            <div class="col-sm-2">
                <button style="background-color: #2d5986; color: white;" class="btn btn-primary" type="submit">
                    <i data-feather="search"></i><span class="px-2">Pesquisar</span>
                </button>
            </div>
        </form>

    </div>
</div>

<?php
if (!empty($busca)) {
    ?>
    <div class="row">
        <div class="col">
            <div class="alert alert-light mb-0 fs-4" role="alert">
                Voce esta buscando por: "<mark class="fst-italic"><?= $buscaOriginal ?></mark>", 
                <a class="link-small" href="?ordem=<?= $ordem ?>">Limpar</a><br>
            </div>
        </div>
    </div>
    <?php
}

?>
    <div class="container"><br><br>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g3">
            <?php
            $resultados = 0;

            while ($row = $stmt->fetch()) {
                $resultados++;

                ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row["servico_nome"] ?></h5><br>
                                <img src="img/<?= $row["servico_foto"] ?> " alt="foto" class="img-fluid mb-3" ><br>
                                
                                <hr class="mt-0 mb-2"><br><br>
                                <a class="card-text btn btn-sm btn-warning" href="servico-info.php?id_servico=<?= $row["servico_id"] ?>">
                                    Saiba Mais
                                </a>
                                <!--<p class="card-text text-end">ID: <b><?= $row["servico_id"] ?></b></p>-->

                                <?php
                                if (autenticado() && $row["usuario_logado"] == id_usuario()) {
                                    ?>
                                    <td class="text-end">
                                        <a class="btn btn-sm btn-warning"
                                            href="formulario-alterar-servicos.php?id=<?= $row["servico_id"] ?>">
                                            <span data-feather="edit"></span>
                                            Alterar
                                        </a>
                                    </td>

                                    <td class="text-end">
                                        <a class="btn btn-sm btn-danger" href="excluir-servico.php?id=<?= $row["servico_id"] ?>"
                                            onclick="if(!confirm('Tem certeza que deseja excluir?')) return false;">
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
            if($resultados === 0 && !empty($buscaOriginal)){
                ?>
                    <div class="col mt-2">
                        <div>
                            <p class="alert alert-light fs-6">Nenhum serviço encontrado</p>
                             <a href="">Ver todos</a>
                        </div>
                    </div>
                <?php
            }
            ?>
        </div>
    </div>



<?php

require 'rodape.php'
    ?>