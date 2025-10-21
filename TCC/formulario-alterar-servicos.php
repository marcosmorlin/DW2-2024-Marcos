<?php

session_start();
require "logica-autenticacao.php";

if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}

$titulo_pagina = "Alteração de Serviços";
require 'cabecalho.php';

require 'Conexao.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$id_usuario = id_usuario();

if(empty($id)){
    
    ?>
    
        <div class="alert alert-danger" role="alert">
            <h4>Falha ao abrir formulário para edição</h4>
            <p>ID do Serviço está vazio.</p>
        </div>
    <?php
    exit();

} else {

    //verificar se serviço pertence ao usuario logado

    $sqlVerificar = "SELECT sp.id_servico 
                    FROM servico_profissional sp
                    JOIN profissionais p ON sp.id_profissional = p.id 
                    WHERE p.id_usuario = ? AND sp.id_servico = ?";
    $stmtVerificar = $conn->prepare($sqlVerificar);
    $stmtVerificar->execute([$id_usuario, $id]);
    $resultProfissional = $stmtVerificar->fetch();

    
    if(!$resultProfissional){

        ?>
            <div class="alert alert-danger" role="alert">
                <h4>Operação não permitida !!!</h4>
                <p>Esse servico não pertence ao usuario.</p>
            </div>
        <?php
        exit();

    }
}

$sql= "SELECT nome, descricao, foto_servico FROM servicos WHERE id = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id]);

$rowServico = $stmt->fetch();


//var_dump($rowServico);
?>

    <script>
        var imagePreview = function(event){
            var foto_servico = document.getElementById('image-preview');
            foto_servico.src = URL.createObjectURL(event.target.files[0]);
            foto_servico.onload = function(){
                URL.revokeObjectURL(foto_servico.src);
            }

            if(event.target.files[0]){
                foto_servico.style.display = 'inline';
            } else {
                foto_servico.style.display = 'none';
            }
        };
     
    </script>


    <form action="alterar-servico.php"  method="Post" enctype="multipart/form-data"> 
        <input type="hidden" name="id" id="id" value="<?= $id?>">
        <div class="row">
            <div class="col-7">
                <div class="mb-3">
                    <div class="col-12">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" 
                        id="nome" name="nome" required
                        value="<?=$rowServico['nome']?>">
                    </div>
                           
                </div>
        
                <div class="mb-5">
                    <label class="form-label" for="descricao">
                        Descrição do Serviço:
                    </label>
                    <textarea class="form-control" name="descricao" rows="5" id="descricao"><?=$rowServico['descricao']?></textarea>
                </div>

                <div class="mb-3">
                    <div class="col-sm-7">
                        <label for="foto_servico"> Foto/Imagem do serviço</label>
                        <input type="file" class="form-control" accept="image/*" id="foto_servico" name="foto_servico" 
                        onchange= "imagePreview(event)">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-success">
                    Alterar
                    <span data-feather="check"></span>
                </button>

                <button type="reset" class="btn btn-danger">
                    Cancelar
                    <span data-feather="x"></span>
                </button>
            </div>
            <div class="col-4">
                <img src="img/<?= $rowServico['foto_servico'] ?>" alt="<?= $rowServico['nome']?>" 
                class="img-thumbnail w-100" id="image-preview">
            </div>
        </div>
    </form>

<?php

require 'rodape.php'

?>