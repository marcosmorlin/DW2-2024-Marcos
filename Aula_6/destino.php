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

        echo"<p>Nome digitado: $nome<br>Email: $email</p>";
    ?>
    <br>

    <p>

        <a href="destino.php?nome=marcos&email=marcos%40gmail.com&cor=lightgreen">
            Enviar dados = [nome = marcos | email = marcos@gmail]
        </a>

    </p>
    <br>

    <br>
    <a href="destino.php?nome=Marcos&email=aaa">
        segundo link
    </a> 

    </p>
   
    <style>
        body{
            background-color: <?php echo $cor;?>;
        }
    </style>


</body>
</html>