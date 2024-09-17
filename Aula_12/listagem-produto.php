<?php

session_start();
require "logica-autenticacao.php";

$titulo_pagina = "Listagem de produtos";
require 'cabeçalho.php';

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

    if($tipo_busca == "id"){

        $sql = "SELECT p.id, p.nome, c.nome as categoria, urlfoto, descricao from produtos p
                join categorias c on c.id = p.id_categoria WHERE p.ID = ? ORDER BY p.$ordem";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$busca]);
        
    } elseif($tipo_busca == "nome"){

        $sql = "SELECT p.id, p.nome, c.nome as categoria, urlfoto, descricao from produtos p
                join categorias c on c.id = p.id_categoria WHERE p.nome ilike ? ORDER BY p.$ordem";

        $busca = '%'.$busca.'%';
        $busca = str_replace(' ', '%', $busca);


        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$busca]);

    } elseif($tipo_busca == "descr"){

        $sql = "SELECT p.id, p.nome, c.nome as categoria, urlfoto, descricao from produtos p
                join categorias c on c.id = p.id_categoria WHERE p.descricao ilike ? ORDER BY p.$ordem";

        $busca = '%'.$busca.'%';
        $busca = str_replace(' ', '%', $busca);

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$busca]);

    } else {

        $sql = "SELECT p.id, p.nome, c.nome as categoria, urlfoto, descricao from produtos p
                join categorias c on c.id = p.id_categoria 
                WHERE   p.ID = ? OR
                        p.nome ilike ? OR
                        p.descricao ilike ? 
                ORDER BY p.$ordem";

        $buscaInt = intval($busca);
        $busca = '%'.$busca.'%';
        $busca = str_replace(' ', '%', $busca);

        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([$buscaInt, $busca, $busca]);
        
    }

} else {
    $busca = null;
    $tipo_busca = null;

    $sql = "SELECT  p.id, p.nome, c.nome as categoria, urlfoto, descricao from produtos p
            join categorias c on c.id = p.id_categoria order by p.$ordem";
    $stmt = $conn->query($sql);
}

?>

<div class="row">
    <div class="col">

        <form class="row" role="search" method="post" action="?ordem=<?=$ordem?>">

            <label for="tipo_busca" class="fs-5 col-sm-2 col-form-label-sm text-end">
                Buscar por:
            </label>
            <div class="col-sm-2">
                <select name="tipo_busca" id="tipo_busca" class="form-select">
                    <option value="" <?php if(empty($tipo_busca)) echo "selected"; ?>>Todos os campos</option>
                    <option value="id" <?php if($tipo_busca == "id") echo "selected"; ?>>ID</option>
                    <option value="nome" <?php if($tipo_busca == "nome") echo "selected"; ?>>Nome</option>
                    <option value="descr" <?php if($tipo_busca == "descr") echo "selected"; ?>>Descricao</option>
                </select>
            </div>
            <div class="col-sm-6">
                <input class="form-control me-2" type="search" name="busca" id="busca"
                placeholder="Search" aria-label="Search">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" type="submit">
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
                Voce esta buscando por: "<mark class="fst-italic"><?=$buscaOriginal?></mark>", <a href="?ordem=<?= $ordem ?>">Limpar</a>
            </div>
        </div>
    </div>
<?php
}

?>
<hr>
<div class="table-responsive">
    <table class="table table-striped">
        <thead class="table-success">
            <tr>
                <?php
                if($ordem == "nome"){
                ?>
                    <th scope="col" style="width 10%; ">
                        <a href="?ordem=id">ID</a>
                    </th>
                    <th scope="col" style="width 25%; ">
                        Nome <i data-feather="chevron-down"></i>
                    </th>
                <?php
                } else {
                ?>
                    <th scope="col" style="width 10%; ">
                        ID<i data-feather="chevron-down"></i>
                    </th>
                    <th scope="col" style="width 25%; ">
                        <a href="?ordem=nome">Nome</a> 
                    </th>
                <?php
                }
                
                ?>
                <th scope="col" style="width 10%; ">Categoria</th>
                <th scope="col" style="width 15%; ">Imagem</th>
                <th scope="col" style="width 20%; ">Descrição</th>
                <?php
                if(autenticado() && isAdmin()){
                ?>
                    <th scope="col" style="width 20%;   " colspan="2"></th>
                <?php
                }
                ?>
                <?php
                if(autenticado()){
                ?>
                    <th scope="col" style="width 20%;"></th>
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
            <td>
                <?= $row["categoria"]?>
            </td>
            <td>
                <a target="_blank" href="<?=$row["urlfoto"]?>">
                    Link imagem
                </a>
            </td>
            <td class="descri">
                <?= $row["descricao"]?>
            </td>
            <?php
        
            if(autenticado()){
            ?>
                <td>
                    <a class="btn btn-sm btn-warning" href="formulario-alterar-produto.php?id=<?=$row["id"]?>">
                        <span data-feather="edit"></span>
                        Editar
                    </a>
                </td>
                <?php
                    if(isAdmin()){
                ?>
                <td>
                    <a class="btn btn-sm btn-danger" href="excluir-produto.php?id=<?=$row["id"]?>"
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
        </tr>
        <tr>
            <td>2</td>
            <td>Tênis Masculino Adidas Coreracer - Preto+Branco</td>
            <td>
                <a target="_blank" href="https://encrypted-tbn3.gstatic.com/shopping?q=tbn:ANd9GcQFManwlOoeyxa2QwEz8lE_G44kYtE3AWjS8_QWnVG-mLU99kqqh7GZIbE55th4tl6tNnQH5fEc6vvQRQXFZrRWwpy2sNdH83XindmNnOYM4GGVoEAj_p472Y-wRXTZO7mEklqq&usqp=CAc">
                    Link imagem
                </a>
            </td>
            <td>
            Indicado para: Caminhada, Corrida
            Material: Têxtil
            Composição: Cabedal: Têxtil e Mesh; Entressola: EVA; Solado: Borracha e contra-salto de inspiração tecnológica
            Pisada: Neutra
            Importante: Para um melhor ajuste nos pés, recomendamos a compra de um tamanho maior do que o seu usual. Forma Pequena.
            Garantia do Fabricante: Contra defeito de fabricação
            </td>
            <td>
                <a class="btn btn-sm btn-warning" href="#">
                    <span data-feather="edit"></span>
                    Editar
            </td>
            <td>
                <a class="btn btn-sm btn-danger" href="#">
                    <span data-feather="trash-2"></span>
                    Excluir
            </td>

        </tr>
        <tr>
            <td>3</td>
            <td>Kit 3 Bermudas De Brim Sarja Padrão Shopping Envio Imediato</td>
            <td>
                <a target="_blank" href="https://http2.mlstatic.com/D_NQ_NP_948061-MLB69571776771_052023-O.webp">
                    Link imagem
                </a>
            </td>
            <td>
            Bermuda Masculina de Brim - Qualidade Padrão Shopping Produzidas em tecido Brim/Fio Tinto, 100% Algodão. Modelo com 4 bolsos, sendo dois frontais e dois traseiros. Possuem fechamento frontal por zíper e botão e cós com passantes (riatas) para cintos. Não trabalhamos com réplicas ou falsificações. * Tecido original de fábrica (não desbota); * Confeccionada em alto padrão de qualidade; * Botões de ferro e zíper reforçado; * Modelagem com ótimo caimento; * Bolsos frontais e traseiros fundos; * Cores que combinam com tudo; * Conforto e estilo garantido;

            Garantia do vendedor: 7 dias
            </td>
            <td>
                <a class="btn btn-sm btn-warning" href="#">
                    <span data-feather="edit"></span>
                    Editar
            </td>
            <td>
                <a class="btn btn-sm btn-danger" href="#">
                    <span data-feather="trash-2"></span>
                    Excluir
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td>Boné New Era MLB New York Yankees I Marinho</td>
            <td>
                <a target="_blank" href="https://m.media-amazon.com/images/I/61wJnP8yqML._AC_SX522_.jpg">
                    Link imagem
                </a>
            </td>
            <td>
            Sobre este item
            Bone
            940 snapback
            Acessórios masculinos; gorros, chapéus e bonés
            940 snapback
            Acessórios masculinos; gorros, chapéus e bonés
            
            </td>
            <td>
                <a class="btn btn-sm btn-warning" href="#">
                    <span data-feather="edit"></span>
                    Editar
            </td>
            <td>
                <a class="btn btn-sm btn-danger" href="#">
                    <span data-feather="trash-2"></span>
                    Excluir
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