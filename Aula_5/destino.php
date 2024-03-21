<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destino</title>
</head>

<body>

    <p>
        <a href="Praticando1.html">Voltar para o formulário</a>
    </p>

    <?php

    $titulo = filter_input(INPUT_POST, "titulo", FILTER_SANITIZE_SPECIAL_CHARS);
    $corpo = filter_input(INPUT_POST, "corpo", FILTER_SANITIZE_SPECIAL_CHARS);
    $cor = filter_input(INPUT_POST, "cor", FILTER_SANITIZE_SPECIAL_CHARS);
    $homepage1 = filter_input(INPUT_POST, "homepage1", FILTER_SANITIZE_URL);
    $homepage2 = filter_input(INPUT_POST, "homepage2", FILTER_SANITIZE_URL);
    $corbg = filter_input(INPUT_POST, "corbg", FILTER_SANITIZE_SPECIAL_CHARS);

    ?>
    <br>

    <style>
        body{
            background-color: <?php echo $corbg;?>;
            color: <?php echo $cor;?>;
        }
    </style>
    
    <h1>
        <?php
            echo $titulo;
        ?>
    </h1>
    <br>

    <p>
        <?php 
            echo $corpo; 
        ?>
    </p>

    <img src="<?php echo $homepage1; ?>">;

    <br>
    <p>
        <a href="<?php echo $homepage2; ?>">
            https://vtp.ifsp.edu.br/index.php/informativos/3637-arduino-day-2024.html
        </a>;
    </p>

</body>

</html>