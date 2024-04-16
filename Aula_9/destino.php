<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destino</title>
</head>


<body>
    
    <p>
        <a href="Praticando.html">Voltar para o formulario</a>
    </p>


    <h1>Destino</h1>
    <hr>

    <?php
        echo "<h1> Dados Da Requisição: ";

    ?>
    <br>

    <textarea id="text" name="text" rows="15" cols="140">
        
        <?php
           var_dump($_POST);
        ?> 
    </textarea><br>

    <?php
        echo "<h1>Interesses Selecionados (em ordem alfabética)</h1>";

        
    ?>

</body>
</html>