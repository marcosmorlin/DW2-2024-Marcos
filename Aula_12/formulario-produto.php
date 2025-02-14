<?php

session_start();
require "logica-autenticacao.php";

/** Tratamento de permissoes */
if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}   
/** Tratamento de permissoes */

require 'Conexao.php';

$sql = "SELECT id, nome FROM categorias ORDER BY 2";
$stmt = $conn->query($sql);

$titulo_pagina = "Formulario de cadastro de produtos";
require 'cabeçalho.php'

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

    <form action="inserir-produto.php"  method="Post"> 

        <div class="row">
            <div class="col-8">
                <div class="mb-3 row">
                    <div class="col-8">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="col-4">
                        <label for="categoria" class="form-label">Categoria do produto</label>
                        <select class="form-select" name="categoria" id="categoria">
                            <option>[Selecione]</option>
                            <?php
                            while($row = $stmt->fetch()){
                                ?>
                                    <option value="<?= $row["id"]?>"><?= $row["nome"]?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="urlfoto" class="form-label">
                        URL de uma foto/Imagem do produto
                    </label>
                    <input type="url" class="form-control" id="urlfoto" name="urlfoto" aria-describedby="urlforoHelp" required onchange= "imagePreview(this.value)">
                    <div id="urlfotoHelp" class="form-text">
                        Endereço http de uma imagem da internet
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="descricao">
                        Descrição detalhada do produto
                    </label>
                    <textarea class="form-control" name="descricao" id="descricao"></textarea>
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

require 'rodape.php'

?>