<?php
session_start();
require 'logica_autenticacao.php';

$titulo_pagina = "formulario de cadastro de usuarios";
require 'cabeçalho.php';

?>
<script>
    function verifica_senhas(){
        var senha = document.getElementbyId("senha");
        var confsenha = document.getElementbyId("confsenha");

        if(senha.value && confsenha.value){
            if(senha.value != confsenha.value){
                senha.classList.add("is-invalid");
                confsenha.classList.add("is-invalid");
                confsenha.value = null;
            } else {
                senha.classList.remove("is-invalid");
                confsenha.classList.remove("is-invalid");
            }
        }
    }
</script>
<form action="inserir-usuario.php" method= "Post" class="mb-4">
    <div class="row">
        <div class="col-3">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="mb-3">
                <label for="confsenha" class="form-label">Confirmação senha</label>
                <input type="password" class="form-control" id="confsenha" name="confsenha" 
                required aria-describedby="confsenha confsenhaFeedback" onblur="verifica_senhas();">
                <div id="confsenhaFeedback" class="invalid-feedback">
                    As senhas não estão iguais.
                </div>
            </div>
        </div>
        <div class="col-3">
            <img src="https://www.kindpng.com/picc/m/3-39853_add-user-group-woman-man-icon-user-add.png" class="img-thumbnail">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Gravar</button>
    <button type="reset" class="btn btn-warning">Cancelar</button>

</form>

<?php
if(isset($_SESSION["result"])) {

    if($_SESSION["result"]){
        // SE DEU CERTO O RESULT FOR TRUE
        ?>
    
        <div class="alert alert-success" role="alert">
            <h4>Dados gravados com sucesso.</h4>
            <p>
                Clique <a href="form-login.php">aqui</a>
                para se autenticar.
            </p>
        </div>
<?php

    } else {
        $erro = $_SESSION["erro"];
        unset($_SESSION["erro"]);
    ?>
    
        <div class="alert alert-danger" role="alert">
            <h4>falha ao efetuar gravação.</h4>
            <p><?php echo $erro ?></p>
        </div>
<?php
    }

unset($_SESSION["result"]);
}

require 'rodape.php';
?>
