<style>

    #keyboard:hover{
        cursor: not-allowed;
    }
</style>
<?php

?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<?php
session_start();
require "logica-autenticacao.php";
require "Conexao.php";

if (!isset($_GET["email"]) || empty($_GET["email"])) {
    echo "<p class='alert alert-danger'>Usuario não especificado.</p>";
    exit;
}

$email = urldecode($_GET["email"]);

$sql = "SELECT id, nome, email, 'usuario' as tipo
            FROM usuarios
            WHERE email = ? 
            UNION
        SELECT id, nome, email, 'admin' as tipo
        FROM administradores 
        WHERE email = ?";

$stmt = $conn->prepare($sql);
$stmt->execute([$email, $email]);
$usuario = $stmt->fetch();

if (!$usuario) {
    echo "<p class='alert alert-danger'>Usuario não encontrado.</p";
    exit;
}

$sql = "SELECT * from profissionais WHERE id_usuario = ? ";
$stmt = $conn->prepare($sql);
$stmt->execute([$usuario["id"]]);
$profissional = $stmt->fetch();


$titulo_pagina = "PERFIL GERAL DE " . mb_strtoupper($usuario["nome"]);
require 'cabecalho.php';
?>

    <div class="container py-5 bg-light">
        <?php
            if(!$profissional){
                echo "<p class='text alert-info d-inline-block'><i class='bi bi-info-circle-fill'></i>
                Usuario não cadastrado como Profissional.</p>";
            }
        ?>

        <hr>
        <form action="formulario-alterar-dados-perfil.php" method="post">
            <input type="hidden" name="id" value="<?= $usuario["id"]  ?>">
        
            <div class="col-md-6 mb-3">
                <label for="text">Nome:</label>
                <input type="text" id="keyboard" class="form-control" name="nome" value="<?= $usuario["nome"]  ?>" required readonly>
            </div>

            <div class="col-md-6 mb-3">
                <label for="text">E-mail:</label>
                <input type="text" id="keyboard" class="form-control" name="email" value="<?= $usuario["email"]  ?>" readonly>
            </div>

            <?php
                if ($profissional) {
                    ?>

                        <div class="col-md-6 mb-3">
                            <label for="phone">Telefone:</label>
                            <input type="phone" id="keyboard" class="form-control"name="telefone" value="<?= $profissional["telefone"] ?>" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="text">Rede Social:</label>
                            <input type="text" id="keyboard" class="form-control" name="rede_social" value="<?= $profissional["rede_social"] ?>" readonly>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="text">Descrição:</label>
                            <textarea id="keyboard" class="form-control" name="descricao" readonly><?= $profissional["descricao"] ?></textarea>
                        </div>

                    <?php
                } 
            ?>

            <a href="formulario-alterar-dados-perfil.php?id=<?= $usuario["id"] ?>" type="submit" class="btn btn-sm btn-warning mt-3">
                <span data-feather="edit"></span>
                Alterar Dados
            </a>

            <a class="btn btn-sm btn-danger mt-3" href="excluir-usuario.php?id=<?= id_usuario(); ?>" onclick="if(!confirm('Tem certeza que deseja excluir?')) return false;">
                <span data-feather="trash-2"></span>
                Excluir Conta
            </a>
        </form>

    </div>


<?php
require 'rodape.php'
?>