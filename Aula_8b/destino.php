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


    <h1>Destino GET</h1>
    <hr>

    <?php

        $inicio = filter_input(INPUT_POST, "inicio", FILTER_SANITIZE_SPECIAL_CHARS);
        $Final = filter_input(INPUT_POST, "Final", FILTER_SANITIZE_SPECIAL_CHARS);
        $Incremento = filter_input(INPUT_POST, "Incremento", FILTER_SANITIZE_SPECIAL_CHARS);

    ?>

    <br>

    <p>
        <?php

        echo "<h1>Parâmetros Informados: </h1> ";

        ?>
    </p>

    <p>
        <?php
            echo "Inicio " . " : " . $inicio;
        ?>
    </p>

    <p>
        <?php
            echo "Final " . " : " . $Final;
        ?>
    </p>

    <p>
        <?php
            echo "Incremento " . " : " . $Incremento;
        ?>
    </p>

    <p>
        <?php

        for($i = $inicio; $i = $Final; $i += $Incremento){
            echo $i . " ";
        }

        ?>
    </p>
</body>
</html>