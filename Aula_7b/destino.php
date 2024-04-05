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

        $nota1 = filter_input(INPUT_POST, "nota1", FILTER_SANITIZE_SPECIAL_CHARS);
        $nota2 = filter_input(INPUT_POST, "nota2", FILTER_SANITIZE_SPECIAL_CHARS);
        $nota3 = filter_input(INPUT_POST, "nota3", FILTER_SANITIZE_SPECIAL_CHARS);

        $media = ($nota1 + $nota2 + $nota3) / 3;

        if($media < 4){
            $mensagem = "Reprovado";
        }
        elseif($media >= 4 && $media < 6){
            $mensagem = "De recuperação";
        }
        elseif($media >= 6){
            $mensagem = "Aprovado";
        }

    ?>
    <br>

    <p>
        <?php

        echo "Um aluno com as notas ". $nota1 . ", " . $nota2 . " e " . $nota3 . " tem uma média igual a: ". $media;

        ?>

    </p>
    <br>

    <p>

    <?php

        echo "Com essa média o aluno está " . $mensagem;
    ?>
    </p>
</body>
</html>