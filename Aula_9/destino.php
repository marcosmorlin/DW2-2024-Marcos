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
            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";
        ?> 
    
    </textarea><br>

    

    <?php
        echo "<h1>Interesses Selecionados (em ordem alfabética)</h1>";

        $interesses = array_values($_POST);
        sort($interesses);

        echo "<ul>";

        for($i = 0; $i < min (3, count($interesses)); $i++){
            echo "<li>$interesses[$i]</li>";
        }
        
        echo "</ul>";

        if(count($interesses) > 3){
            echo "<li>...</li>";
        }

    ?>

</body>
</html>