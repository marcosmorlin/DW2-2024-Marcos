<?php

session_start();
require "logica-autenticacao.php";

/** Tratamento de permissoes */
if(!autenticado() || !isAdmin()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}   
/** Tratamento de permissoes */

require 'Conexao.php';

// se veio um 'id' aqui, esta tentando alterar
if(isset($_GET["id"])){
    // bloco de alteração da categoria
    $id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
    
    $sql= "SELECT nome FROM categorias WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    $rowCategoria = $stmt->fetch();
    $nome = $rowCategoria["nome"];
    $action = "alterar-categoria.php";

} else{
    // bloco de insercao de categoria
    $id = null;
    $nome = null;
    $action = "inserir-categoria.php";
}


$sql = "SELECT id, nome FROM categorias ORDER BY nome";
$stmt = $conn->query($sql);

$titulo_pagina = "Formulario de cadastro de categorias";
require 'cabeçalho.php'

?>

    <form action="<?= $action ?>" method="Post" class="mb-3"> 
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="row">
            <div class="col-8">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $nome ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Gravar</button>
                <button type="reset" class="btn btn-warning">Cancelar</button>
            </div>
            <div class="col-3">
                <img src="" 
                alt="-" class="img-thumbnail" id="image-preview" style="display: none;">
            </div>
        </div>
    </form>

<?php

if(isset($_SESSION["result"])) {

    if($_SESSION["result"]){
        // SE DEU CERTO O RESULT FOR TRUE
        ?>
    
        <div class="alert alert-success" role="alert">
            <h4><?= $_SESSION["mensagem_sucesso"] ?></h4>
        </div>
    <?php
        unset($_SESSION["mensagem_sucesso"]);
    } else {
    ?>
    
        <div class="alert alert-danger" role="alert">
            <h4><?= $_SESSION["mensagem_erro"] ?></h4>
            <p><?= $_SESSION["erro"] ?></p>
        </div>
<?php

    unset($_SESSION["mensagem_erro"]);
    unset($_SESSION["erro"]);

    }

    unset($_SESSION["result"]);
}
?>

<div class="table-responsive">
    <table class="table table-stripped">
        <thead>
            <tr>
                <th scope="col" style="width: 10%;">ID</th>
                <th scope="col" style="width: 60%;">Nome</th>
                <th scope="col" style="width: 30%;" colspan="2"></th>
             </tr>
        </thead>
        <tbody>
            <?php
            while($row = $stmt->fetch()){
            ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row["nome"] ?></td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-warning" href="formulario-categorias.php?id=<?= $row["id"] ?>">
                            <span data-feather="edit"></span>
                            Editar
                        </a>
                    </td>
                    <td class="text-center">
                        <a class="btn btn-sm btn-danger" href="excluir-categoria.php?id=<?= $row["id"] ?>" onclick="if(!confirm('Tem certeza que deseja excluir?')) return false;">
                            <span data-feather="trash-2"></span>
                            Excluir
                        </a>
                    </td>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
<?php


require 'rodape.php'

?>