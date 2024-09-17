<?php
session_start();
require 'logica-autenticacao.php';

$titulo_pagina = "Formulario de alteraçao de produtos";
require 'cabeçalho.php';

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

$sql= "SELECT nome, urlfoto, descricao, id_categoria FROM produtos WHERE id = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$id]);

$rowProduto = $stmt->fetch();

$sqlCategoria = "SELECT id, nome FROM categorias ORDER BY 2";
$stmtCategoria = $conn->query($sqlCategoria);

?>
    <script>
        function imagePreview(valor){
            var img = document.getElementById('image-preview');
            if(valor){
                img.setAttribute('src', valor);
                img.style.display = 'inline';
            } else {
                img.style.display = 'none';
            }
        }
        
    </script>

    <form action="alterar-produto.php"  method="Post"> 
        <input type="hidden" name="id" id="id" value="<?= $id?>">

        <div class="row">
            <div class="col-8">
                <div class="mb-3">
                    <div class="mb-3 row">
                        <div class="col-8">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= $rowProduto['nome']?>" required>
                        </div>
                        <div class="col-4">
                            <label for="categoria" class="form-label">Categoria do produto</label>
                            <select class="form-select" name="categoria" id="categoria">
                                <option>[Selecione]</option>
                                <?php
                                while($rowCategoria = $stmtCategoria->fetch()){
                                        if($rowProduto['id_categoria'] == $rowCategoria['id']){
                                            $selected = " selected ";
                                        } else {
                                            $selected = " ";
                                        }
                                    ?>
                                        <option <?= $selected ?>value="<?= $rowCategoria["id"]?>"><?= $rowCategoria["nome"]?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="urlfoto" class="form-label">URL de uma foto/Imagem do produto</label>
                    <input type="url" class="form-control" id="urlfoto" name="urlfoto" aria-describedby="urlforoHelp" required
                    value="<?= $rowProduto['urlfoto']?>" onkeypress= "imagePreview(this.value)">
                    <div id="urlfotoHelp" class="form-text">
                        Endereço http de uma imagem da internet
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="descricao">Descrição detalhada do produto</label>
                    <textarea class="form-control" name="descricao" id="descricao"><?=$rowProduto['descricao']?></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Gravar</button>
                    <button type="reset" class="btn btn-warning">Cancelar</button>
                </div>
            </div>
            <div class="col-3">
                <img src="<?= $rowProduto['urlfoto']?>" 
                alt="<?= $rowProduto['nome']?>" class="img-thumbnail" id="image-preview">
            </div>
        </div>
    </form>

<?php

require 'rodape.php'

?>