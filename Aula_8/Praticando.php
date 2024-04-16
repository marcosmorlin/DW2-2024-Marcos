<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Praticando GET</title>
        <link rel="stylesheet" href="bootstrap-5.3.2-dist/css/bootstrap.min.css">
    </head>

    <body>

        <a href="../Aula_8/Menu Principal.html" target="_self">
            <p>Voltar ao Menu</p>
        </a>

        <h1>Praticando - Tabuada GET</h1>
        <hr>

        <form action="Praticando.php" method="GET">
            <label for="fnum">Numero:</label><br>
            <input id="n1" type="number" name="numero"><br>

            <br>
            <button class="btn btn-success" type="submit">Enviar</button>
            <button class="btn btn-warning" type="reset">Limpar</button>
        </form>
        <hr>

        <?php

        $numero = filter_input(INPUT_GET, "numero", FILTER_SANITIZE_SPECIAL_CHARS);

        echo "<h1>Tabuada do " . $numero . " :</h1>";

        for($i = 1; $i <= 10; $i++){
            echo "$numero * $i = " .  $numero * $i. "</br>"; 
        }
    
        ?>
    <br>

    </body>

</html>

