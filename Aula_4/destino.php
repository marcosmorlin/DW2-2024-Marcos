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


    <h1>Destino</h1>
    <hr>

    <?php

        $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $cor = filter_input(INPUT_POST, "cor", FILTER_SANITIZE_SPECIAL_CHARS);

        echo"<p>Nome digitado: $nome<br>Email: $email</p>";
    ?>
    <br>
   
    <style>
        body{
            background-color: <?php echo $cor;?>;
        }
    </style>


</body>
</html>