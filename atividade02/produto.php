<?php

// Inicia a sessão
session_start();


// =====================================================
// PROTEÇÃO DA PÁGINA
// =====================================================

// Verifica se o usuário está logado
if (!isset($_SESSION["usuario"])) {

    // Se não estiver logado, volta para o login
    header("Location: login.php");

    exit;
}


// Arquivo onde os produtos serão armazenados
$arquivoProdutos = "produtos.txt";


// Variáveis para mensagens
$mensagem = "";
$tipoMensagem = "";


// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebe os dados do formulário
    $nome = trim($_POST["nome"] ?? "");

    $preco = trim($_POST["preco"] ?? "");

    $descricao = trim($_POST["descricao"] ?? "");


    // Converte vírgula para ponto
    // Exemplo: 129,90 -> 129.90
    $preco = str_replace(",", ".", $preco);


    // =====================================================
    // VALIDAÇÃO DOS CAMPOS
    // =====================================================

    if ($nome === "" || $preco === "" || $descricao === "") {

        $mensagem = "Preencha todos os campos.";

        $tipoMensagem = "erro";

    }

    elseif (!is_numeric($preco) || $preco < 0) {

        $mensagem = "Digite um preço válido.";

        $tipoMensagem = "erro";

    }

    elseif (!isset($_FILES["imagem"]) || $_FILES["imagem"]["error"] !== UPLOAD_ERR_OK) {

        $mensagem = "Selecione uma imagem válida.";

        $tipoMensagem = "erro";

    }

    else {

        // =================================================
        // TRATAMENTO DA IMAGEM
        // =================================================

        $foto = $_FILES["imagem"];


        // Tamanho máximo permitido: 5 MB
        $tamanhoMaximo = 5 * 1024 * 1024;


        if ($foto["size"] > $tamanhoMaximo) {

            $mensagem = "A imagem deve ter no máximo 5 MB.";

            $tipoMensagem = "erro";

        }

        else {

            // Pega a extensão da imagem
            $extensao = strtolower(
                pathinfo($foto["name"], PATHINFO_EXTENSION)
            );


            // Extensões permitidas
            $extensoesPermitidas = [
                "jpg",
                "jpeg",
                "png",
                "webp",
                "avif"
            ];


            // Verifica se a extensão é permitida
            if (!in_array($extensao, $extensoesPermitidas)) {

                $mensagem = "Formato de imagem não permitido.";

                $tipoMensagem = "erro";

            }

            else {

                // =================================================
                // CRIA A PASTA DE IMAGENS
                // =================================================

                if (!is_dir("images")) {

                    mkdir("images", 0777, true);
                }


                // Cria um nome único para a imagem
                $nomeImagem =
                    time() .
                    "_" .
                    uniqid() .
                    "." .
                    $extensao;


                // Caminho final da imagem
                $caminho = "images/" . $nomeImagem;


                // Move a imagem para a pasta images
                $uploadRealizado = move_uploaded_file(
                    $foto["tmp_name"],
                    $caminho
                );


                if (!$uploadRealizado) {

                    $mensagem = "Erro ao salvar a imagem.";

                    $tipoMensagem = "erro";

                }

                else {

                    // =================================================
                    // LIMPEZA DOS DADOS
                    // =================================================

                    // O caractere | separa os campos no TXT.
                    // Por isso ele não pode aparecer nos dados.

                    $nome = str_replace(
                        ["|", "\r", "\n"],
                        "-",
                        $nome
                    );

                    $descricao = str_replace(
                        ["|", "\r", "\n"],
                        "-",
                        $descricao
                    );


                    // Formata o preço
                    $preco = number_format(
                        (float)$preco,
                        2,
                        ".",
                        ""
                    );


                    // =================================================
                    // SALVA O PRODUTO NO TXT
                    // =================================================

                    /*
                     * Formato salvo:
                     *
                     * nome|preço|descrição|imagem
                     */

                    $linha =
                        $nome .
                        "|" .
                        $preco .
                        "|" .
                        $descricao .
                        "|" .
                        $caminho;


                    // Adiciona o produto no final do arquivo
                    $resultado = file_put_contents(
                        $arquivoProdutos,
                        $linha . PHP_EOL,
                        FILE_APPEND
                    );


                    if ($resultado !== false) {

                        $mensagem =
                            "Produto cadastrado com sucesso!";

                        $tipoMensagem = "sucesso";

                    } else {

                        $mensagem =
                            "Erro ao salvar o produto.";

                        $tipoMensagem = "erro";
                    }
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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Cadastrar produto - Pixel Store</title>

    <link rel="stylesheet" href="style.css?v=5">

</head>

<body>

<header>

    <h1>Pixel Store</h1>

    <nav>

        <a href="index.php">
            Início
        </a>

        <a href="produto.php">
            Cadastrar produto
        </a>

        <a href="sair.php">
            Sair
        </a>

    </nav>

</header>

<div class="corte"></div>


<main class="paginaFormulario">

    <section class="formularioContainer produtoContainer">

        <div class="iconeFormulario">
            🎮
        </div>

        <span class="etiquetaFormulario">
            PIXEL STORE
        </span>

        <h2>
            Cadastrar produto
        </h2>

        <p class="subtituloFormulario">

            Olá,
            <strong>
                <?= htmlspecialchars($_SESSION["usuario"]) ?>
            </strong>!

            Cadastre um novo produto na loja.

        </p>


        <?php if ($mensagem !== ""): ?>

            <div class="mensagem <?= $tipoMensagem ?>">

                <?= htmlspecialchars($mensagem) ?>

            </div>

        <?php endif; ?>


        <form
            method="POST"
            action="produto.php"
            enctype="multipart/form-data"
        >

            <label for="nome">
                Nome do produto
            </label>

            <input
                type="text"
                id="nome"
                name="nome"
                placeholder="Ex: Mouse Gamer RGB"
                required
            >


            <label for="preco">
                Preço
            </label>

            <input
                type="text"
                id="preco"
                name="preco"
                placeholder="Ex: 129,90"
                required
            >


            <label for="descricao">
                Descrição
            </label>

            <textarea
                id="descricao"
                name="descricao"
                placeholder="Digite uma descrição para o produto..."
                required
            ></textarea>


            <label for="imagem">
                Imagem do produto
            </label>

            <input
                type="file"
                id="imagem"
                name="imagem"
                accept=".jpg,.jpeg,.png,.webp,.avif"
                required
            >


            <button type="submit">
                Cadastrar produto
            </button>

        </form>


        <a href="index.php" class="voltarInicio">
            ← Voltar para a loja
        </a>

    </section>

</main>


<footer>

    <p>
        &copy; 2026 Pixel Store. Todos os direitos reservados.
    </p>

</footer>

</body>

</html>