<?php

$arquivo = "produtos.txt";
$mensagem = "";


/* =====================================================
   CADASTRO DE PRODUTO
   ===================================================== */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");
    $preco = trim($_POST["preco"] ?? "");

    if ($nome === "" || $preco === "") {

        $mensagem = "Preencha o nome e o preço do produto.";

    } elseif (!isset($_FILES["imagem"]) || $_FILES["imagem"]["error"] !== UPLOAD_ERR_OK) {

        $mensagem = "Selecione uma imagem válida.";

    } else {

        $imagem = $_FILES["imagem"];

        /*
         * Extensões permitidas
         */

        $extensao = strtolower(
            pathinfo($imagem["name"], PATHINFO_EXTENSION)
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

            /*
             * Cria a pasta imagem caso ela não exista
             */

            if (!is_dir("imagem")) {

                mkdir("imagem", 0777, true);

            }


            /*
             * Cria um nome único para a imagem
             */

            $nomeArquivo =
                time() . "_" .
                uniqid() . "." .
                $extensao;


            $caminho = "imagem/" . $nomeArquivo;


            /*
             * Move a imagem para a pasta
             */

            if (move_uploaded_file(
                $imagem["tmp_name"],
                $caminho
            )) {


                /*
                 * Evita quebrar o arquivo TXT
                 * caso o usuário coloque |
                 * no nome do produto.
                 */

                $nome = str_replace("|", "-", $nome);

                $preco = str_replace("|", "-", $preco);


                /*
                 * Cria a linha do produto
                 */

                $linha =
                    $nome . "|" .
                    $preco . "|" .
                    $caminho;


                /*
                 * Salva no produtos.txt
                 */

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


/* =====================================================
   CARREGAR PRODUTOS
   ===================================================== */

$produtos = [];

if (file_exists($arquivo)) {

    $produtos = file(
        $arquivo,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );

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

    <title>Pixel Store</title>

    <link
        rel="stylesheet"
        href="style.css"
    >

    <script
        src="script.js"
        defer
    ></script>

</head>


<body>


<!-- =====================================================
     CABEÇALHO
     ===================================================== -->

<header>

    <h1>Pixel Store</h1>

    <nav>

        <a href="#inicio">
            Início
        </a>

        <a href="#produtos">
            Produtos
        </a>

        <button
            class="botaoCadastro"
            onclick="abrirCadastro()"
        >
            Cadastrar produto
        </button>

    </nav>

</header>


<div class="corte"></div>


<main>


<!-- =====================================================
     HERO
     ===================================================== -->

<section
    id="inicio"
    class="hero"
>

    <div class="apresentacaoE">

        <h2>
            Seu universo de tecnologia e jogos
        </h2>


        <p>
            Encontre acessórios, periféricos e produtos
            para deixar sua experiência ainda mais completa.
        </p>


        <p>
            Aqui você encontra tudo que um gamer precisa:
            de headsets e teclados mecânicos a PCs de alta
            performance, mouses de precisão e acessórios
            que fazem a diferença na sua gameplay e no seu setup.
        </p>


        <p>
            Na Pixel Store, trabalhamos com uma curadoria
            de produtos pensada para quem joga de verdade,
            oferecendo marcas confiáveis, garantia de procedência
            e suporte especializado.
        </p>


        <p>
            Oferecemos envio rápido e seguro para todo o Brasil,
            além de condições de pagamento que cabem no seu bolso.
        </p>


        <a
            class="botao"
            href="#produtos"
        >
            Ver produtos
        </a>

    </div>


    <div class="apresentacaoD">

        <img
            src="img/imgtopo.avif"
            alt="Produtos de tecnologia e jogos"
        >

    </div>

</section>



<!-- =====================================================
     SAUDAÇÃO
     ===================================================== -->

<section class="saudacao">

    <h2>
        Entre na Pixel Store
    </h2>


    <div class="entrada">

        <input
            type="text"
            class="botaoNome"
            id="nomeVisitante"
            placeholder="Digite seu nome"
        >


        <button
            class="botaoEntrar"
            onclick="darBoasVindas()"
        >
            Entrar na loja
        </button>

    </div>


    <p id="mensagemBoasVindas"></p>

</section>



<!-- =====================================================
     PRODUTOS
     ===================================================== -->

<section
    id="produtos"
    class="secao"
>

    <h2>
        Destaques da semana
    </h2>


    <div class="produtos">


        <?php

        if (!empty($produtos)) {


            foreach ($produtos as $produto) {


                $dados = explode("|", $produto);


                if (count($dados) >= 3) {


                    $nome =
                        htmlspecialchars(
                            trim($dados[0])
                        );


                    $preco =
                        htmlspecialchars(
                            trim($dados[1])
                        );


                    $imagem =
                        htmlspecialchars(
                            trim($dados[2])
                        );


                    echo "

                    <article class='card'>

                        <div class='imagemProduto'>

                            <img
                                src='$imagem'
                                alt='$nome'
                            >

                        </div>


                        <h3>
                            $nome
                        </h3>


                        <p>
                            Produto disponível
                            na Pixel Store.
                        </p>


                        <strong>
                            R$ $preco
                        </strong>


                        <button
                            class='Bcomprar'
                            type='button'
                        >
                            Comprar
                        </button>

                    </article>

                    ";

                }

            }


        } else {


            /*
             * Caso ainda não tenha nenhum produto.
             */

            echo "

            <div class='semProdutos'>

                <h3>
                    Nenhum produto cadastrado
                </h3>

                <p>
                    Cadastre seu primeiro produto
                    para ele aparecer aqui.
                </p>

                <button
                    class='botao'
                    onclick='abrirCadastro()'
                >
                    Cadastrar produto
                </button>

            </div>

            ";

        }

        ?>


    </div>

</section>



<!-- =====================================================
     FORMULÁRIO DE CADASTRO
     ===================================================== -->

<section
    id="cadastro"
    class="cadastro"
>

    <div class="cadastroCaixa">

        <button
            class="fecharCadastro"
            onclick="fecharCadastro()"
        >
            ×
        </button>


        <h2>
            Cadastrar novo produto
        </h2>


        <?php if ($mensagem !== ""): ?>

            <div class="mensagemCadastro">

                <?= htmlspecialchars($mensagem) ?>

            </div>

        <?php endif; ?>


        <form
            action="index.php"
            method="POST"
            enctype="multipart/form-data"
        >


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
                Preço
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
                accept="image/jpeg,image/png,image/webp,image/avif"
                required
            >



            <button
                type="submit"
                class="botaoSalvar"
            >
                Cadastrar produto
            </button>


        </form>

    </div>

</section>


</main>



<!-- =====================================================
     RODAPÉ
     ===================================================== -->

<footer>

    <p>
        &copy; 2026 Pixel Store.
        Todos os direitos reservados.
    </p>

</footer>


</body>

</html>