<?php


$arquivo = "produtos.txt";

if (isset($_POST["nome"]))
    {
        $nome = $_POST["nome"];
        $preco = $_POST["preco"];
        $foto = $_FILES["imagem"];

        $caminho = "imagem/" . time() . "jpg";

        move_uploaded_file(
            $foto["tmp_name"],
            $caminho
        );

        $linha = $nome . "|" . $preco . "|" . $caminho;

        file_put_contents($arquivo, $linha .PHP_EOL, FILE_APPEND);
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

    <form action="" method="POST" enctype="multipart/form-data">;
        <label>Digite o nome do produto:</label>
        <br>
        <input name="nome">
        <br>
        <label>digite o preço do produto:</label>
        <br>
        <input name="preco">
        <br>
        <label>imagem</label>
        <br>
        <input type="file" name="imagem">

    <button type="submit">enviar</button>

    </form>

    <form action="">

    <?php

    $arquivo = "produtos.txt";

    if (file_exists($arquivo))
        {
            $produtos = file($arquivo);

            foreach ($produtos as $produto)
                {
                    $dados = explode("|" ,$produto);
                    echo "<div class='card'>
                    <img src='$dados[2]'>
                    <h2>$dados[0]</h2>
                    <h3>$dados[1]</h3>
                    </div>";
                }
        }


    ?>


    </form>
    
</body>
</html>