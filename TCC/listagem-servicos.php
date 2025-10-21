<style>
    .link-small{
        font-size: 0.8em;
    }
</style>
<?php

session_start();
require "logica-autenticacao.php";

/*Tratamento de permissoes 
if(!autenticado() || !isAdmin()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}   
Tratamento de permissoes 

$titulo_pagina = "Listagem | Busca de serviços";
require 'cabecalho.php';

require 'Conexao.php';

if(isset($_GET["ordem"]) && !empty($_GET["ordem"])){
    $ordem = filter_input(INPUT_GET, "ordem", FILTER_SANITIZE_SPECIAL_CHARS);
} else {
    $ordem = "nome";
}

if(isset($_POST["busca"]) && !empty($_POST["busca"])){

    $busca = filter_input(INPUT_POST, "busca", FILTER_SANITIZE_SPECIAL_CHARS);
    $tipo_busca = filter_input(INPUT_POST, "tipo_busca", FILTER_SANITIZE_SPECIAL_CHARS);
    $buscaOriginal = $busca;

    if($tipo_busca == "profissionais"){

        $sql = "SELECT id, nome, from profissionais WHERE ID = ? ORDER BY $ordem";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$busca]);
        

    } else {

        $sql = "SELECT id, nome, descricao from servicos 
                WHERE   ID = ? OR 
                        nome like ? OR 
                        descricao like ? 
                ORDER BY $ordem";

        $buscaInt = intval($busca);        
        $busca = '%'.$busca.'%';
        $busca = str_replace(' ', '%', $busca);

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$buscaInt, $busca, $busca]);
    }
} else {
    $tipo_busca = null;
    $busca = null;

    $sql = "SELECT id, nome, descricao FROM servicos ORDER BY $ordem";
    $stmt = $conn->query($sql);
}
    ?>

<div class="row">
    <div class="col">
        <form class="row" role="search" method="post" action="?ordem=<?=$ordem?>">
            <!--<label for="tipo_busca" class="fs-5 col-sm-2 col-form-label-sm text-end">
                Filtrar por:
            </label>
            <div class="col-sm-2">
                <select name="tipo_busca" id="tipo_busca" class="form-select">
                    <option value="" <?php if(empty($tipo_busca)) echo "selected"; ?>>Todos os campos</option>  
                    <option value="nome" <?php if($tipo_busca == "nome") echo "selected"; ?> >Nome</option>
                </select>
            </div>-->
            <div class="col-sm-6">
                <input class="form-control me-2" type="search" name="busca" id="busca"
                placeholder="Search" aria-label="Search">
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
if(!empty($busca)){
?>
    <div class="row">
        <div class="col">
            <div class="alert alert-light mb-0 fs-4" role="alert">
                Voce esta buscando por: "<mark class="fst-italic"><?=$buscaOriginal?></mark>", <a class="link-small" href="?ordem=<?= $ordem ?>">Limpar</a>
            </div>
        </div>
    </div>
<?php
}

?>

<hr>
<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                
                <th scope="col" style="width: 10%;">ID</th>
                <th scope="col" style="width: 25%;">Servico</th>
                <th scope="col" style="width: 25%;">Descricao</th>
                <th scope="col" style="width: 25%;">profissional</th>
                <?php
                if(autenticado()){
                ?>
                    <th scope="col style="width: 25%; colspan="2"></th>
                <?php
                }
                ?>
            </tr>
                
        </thead>
        <tbody>
        <?php
        while($row = $stmt->fetch()){
        ?>
        <tr>
            
            <td><?=$row["id"]?></td>
            <td><?=$row["nome"]?></td>
            <td><?=$row["descricao"]?></td>
            
            <?php
            if(autenticado()){
            ?>
            <td class="text-end">
                <a class="btn btn-sm btn-warning" href="formulario-alterar-servicos.php?id=<?=$row["id"]?>">
                    <span data-feather="edit"></span>
                    Editar
                </a>
            </td>

            <td class="text-end">
                <a class="btn btn-sm btn-danger" href="excluir-servico.php?id=<?=$row["id"]?>"
                onclick = "if(!confirm('Tem certeza que deseja excluir?')) return false;">
                    <span data-feather="trash-2"></span>
                    Excluir
                </a>
            </td>
            <?php
            }
            ?>
    
            <?php
        
        }
        ?>
    </tbody>
  
    </table>
        
</div>

<?php

require 'rodape.php'
?>*/