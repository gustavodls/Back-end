<?php

$arquivo = "produtos.txt";

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $preco = trim($_POST["preco"] ?? "");

    if (
        empty($nome) ||
        empty($preco) ||
        !isset($_FILES["imagem"])
    ) {

        $mensagem = "Preencha todos os campos.";

    } else {

        $foto = $_FILES["imagem"];

        if ($foto["error"] !== UPLOAD_ERR_OK) {

            $mensagem = "Erro ao enviar a imagem.";

        } else {

            $pasta = "imagem/";

            if (!is_dir($pasta)) {
                mkdir($pasta, 0777, true);
            }

            $extensao = strtolower(
                pathinfo($foto["name"], PATHINFO_EXTENSION)
            );

            $extensoesPermitidas = [
                "jpg",
                "jpeg",
                "png",
                "webp",
                "avif"
            ];

            if (!in_array($extensao, $extensoesPermitidas)) {

                $mensagem = "Formato de imagem não permitido.";

            } else {

                $nomeArquivo =
                    time() . "_" .
                    uniqid() . "." .
                    $extensao;

                $caminho = $pasta . $nomeArquivo;

                if (move_uploaded_file(
                    $foto["tmp_name"],
                    $caminho
                )) {

                    $linha =
                        $nome . "|" .
                        $preco . "|" .
                        $caminho;

                    file_put_contents(
                        $arquivo,
                        $linha . PHP_EOL,
                        FILE_APPEND
                    );

                    $mensagem =
                        "Produto cadastrado com sucesso!";

                } else {

                    $mensagem =
                        "Não foi possível salvar a imagem.";
                }
            }
        }
    }
}

?>

<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pixel Store - Cadastro</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<header>

    <h1>Pixel Store</h1>

    <nav>

        <a href="index.php">Início</a>

        <a href="catalogo.php">Catálogo</a>

        <a href="atendimento.php">Atendimento</a>

        <a href="admin.php">Cadastrar produto</a>

    </nav>

</header>

<div class="corte"></div>


<main>

    <section class="formulario-container">

        <h2>Cadastrar produto</h2>

        <?php if (!empty($mensagem)): ?>

            <p class="mensagem-admin">
                <?= htmlspecialchars($mensagem) ?>
            </p>

        <?php endif; ?>


        <form
            action="admin.php"
            method="POST"
            enctype="multipart/form-data"
        >

            <fieldset>

                <legend>
                    Informações do produto
                </legend>


                <label for="nome">
                    Nome do produto
                </label>

                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="Ex: Mouse Gamer"
                    required
                >


                <label for="preco">
                    Preço do produto
                </label>

                <input
                    type="text"
                    id="preco"
                    name="preco"
                    placeholder="Ex: 120,00"
                    required
                >


                <label for="imagem">
                    Imagem do produto
                </label>

                <input
                    type="file"
                    id="imagem"
                    name="imagem"
                    accept="image/*"
                    required
                >


                <button type="submit">
                    Cadastrar produto
                </button>

                <a
                    href="index.php"
                    class="botao"
                >
                    Voltar para loja
                </a>

            </fieldset>

        </form>

    </section>

</main>


<footer>

    <p>
        &copy; 2026 Pixel Store. Todos os direitos reservados.
    </p>

</footer>

</body>

</html>