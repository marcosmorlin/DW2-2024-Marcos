<?php

session_start();
require "logica-autenticacao.php";

if(!autenticado()){
    $_SESSION["restrito"] = true;
    redireciona();
    die();
}

$titulo_pagina = "Usuarios";
require 'cabecalho.php';

require 'Conexao.php';

$sql = "SELECT id, nome, email, 'usuario' as tipo FROM usuarios
        UNION
        SELECT id, nome, email, 'admin' as tipo FROM administradores
        ORDER BY nome";

$stmt = $conn->query($sql);

$count = $stmt->rowCount();

if($count == 0){
?>
    <div class="alert alert-warning" role="alert">
        <h4>Atenção</h4>
        <p>Não há nenhum registro na tabela <b>usuários</b></p>
    </div>
<?php

} else {

?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%;">ID</th>
                        <th scope="col" style="width: 35%;">Usuario</th>
                        <th scope="col" style="width: 30%;">Email</th>
                        <th scope="col" style="width: 25%;"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while($row = $stmt->fetch()){
                    ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td>
                                <?php
                                if($row["tipo"] == "admin"){
                                ?>
                                    <span class="text-danger fw-bold">#<?= $row['nome']?></span>
                                <?php
                                } else {
                                ?>
                                    <?= $row['nome']?>
                                <?php
                                }
                                ?>   
                            </td>
                            
                            <td><?= $row['email'] ?></td>
                            <td class="text-end">
                                <?php
                                if(id_usuario() == $row['id'] || isAdmin()){
                                ?>
                                    <a class="btn btn-sm btn-danger" href="excluir-usuario.php?id=<?= $row['id']; ?>" onclick="if(!confirm('Tem certeza que deseja excluir?')) return false;">
                                        <span data-feather="trash-2"></span>
                                        Excluir
                                    </a>
                                <?php
                                } else {
                                ?>

                                    <button type="button" class="btn btn-sm btn-secondary" disabled>
                                        <span data-feather="trash-2"></span>
                                        Excluir
                                    </button>

                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
<?php
}

    if(isset($_SESSION["result"])) {

        if(!$_SESSION["result"]){
            $erro = $_SESSION["erro"];
            unset($_SESSION["erro"]);
        ?>
        
            <div class="alert alert-danger" role="alert">
                <h4>falha ao efetuar exclusao.</h4>
                <p><?php echo $erro ?></p>
            </div>
    <?php
        }

    unset($_SESSION["result"]);
}

require 'rodape.php';
?>