<?php
session_start();
require 'logica-autenticacao.php';

$titulo_pagina = "página de alteração de produtos";
require 'cabeçalho.php';

require 'Conexao.php';

$id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
$urlfoto = filter_input(INPUT_POST, "urlfoto", FILTER_SANITIZE_URL);
$descricao = filter_input(INPUT_POST, "descricao", FILTER_SANITIZE_SPECIAL_CHARS);
$categoria = filter_input(INPUT_POST, "categoria", FILTER_SANITIZE_NUMBER_INT);

echo "<p><b>ID:</b> $id</p>";
echo "<p><b>nome:</b> $nome</p>";
echo "<p><b>URL foto:</b> $urlfoto</p>";
echo "<p><b>descricao:</b> $descricao</p>";

$sql= "UPDATE produtos SET nome = ?, urlfoto = ?, descricao = ?, id_categoria = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$result = $stmt->execute([$nome, $urlfoto, $descricao, $categoria, $id]);
$count = $stmt->rowCount();

if($result == true && $count >= 1){
    //deu certo insert
    ?>
    <div class="alert alert-success" role="alert">
        <h4>Dados alterados sucesso</h4>
    </div>

    <?php
} elseif($result == true && $count == 0){
    ?>
    <div class="alert alert-secondary" role="alert">
        <h4>Nenhum dado foi alterado</h4>
    </div>

    <?php
    
} else {
    //nao deu certo, erro
    $errorArray = $stmt->errorInfo();
?>
    <div class="alert alert-danger" role="alert">
        <h4>Falha ao efetuar gravação</h4>
        <p><?=$errorArray[2]; ?></p>
    </div>
<?php
}
require 'rodape.php'

?>