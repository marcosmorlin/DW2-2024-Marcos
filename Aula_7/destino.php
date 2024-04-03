<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destino</title>
</head>


<body>
    
    <p>
        <a href="formulario.html">Voltar para o formulario</a>
    </p>


    <h1>Destino GET</h1>
    <hr>

    <?php

        $nome = filter_input(INPUT_GET, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_GET, "email", FILTER_SANITIZE_EMAIL);
        $cor = filter_input(INPUT_GET, "cor", FILTER_SANITIZE_SPECIAL_CHARS);

    ?>
    <br>

    <p>
        <?php
         echo "Nome informado: $nome"; 
        ?>
    </p>
    <p>
        <?php
         echo "Email informado: $email"; 
        ?>
    </p>
    <p>
        <a href="destino.php?nome=marcos&email=marcos@gmail.com&cor=<?php echo $cor; ?>">
            [nome = marcos | email = marcos@gmail]
        </a>
    </p>

    <p>
        <a href="destino.php?nome=jose&email=jose@gmail.com&cor=<?php echo $cor; ?>">
            [nome = jose | email = jose@gmail]
        </a>
    </p>

    <p>
        <a href="destino.php">
            Limpar tudo
        </a>
    </p>
    <p>
        <a href="destino.php?cor=red&nome=<?php echo $nome; ?>&email=<?php echo $email?>">
            <img src="imagens/redCanva.png" alt="red">
        </a>
    </p>

    <br>
    <p>
        <a href="destino.php?cor=lightblue&nome=<?php echo $nome; ?>&email=<?php echo $email?>">
            <img src="imagens/blueCanva.png" alt="blue">
        </a>
    </p>

    <br>
    <p>
        <a href="destino.php?cor=lightgreen&nome=<?php echo $nome; ?>&email=<?php echo $email?>">
            <img src="imagens/greenCanva.png" alt="green">
        </a>
    </p>
   
    <style>
        body{
            background-color: <?php echo $cor;?>;
        }
    </style>


</body>
</html>