<?php

// Inicia a sessão para saber se o usuário está logado
session_start();

// Nome do arquivo onde os produtos ficam armazenados
$arquivoProdutos = "produtos.txt";

// Cria uma lista vazia para os produtos
$produtos = [];

// Verifica se o arquivo de produtos existe
if (file_exists($arquivoProdutos)) {

    // Lê todas as linhas do arquivo
    $produtos = file(
        $arquivoProdutos,
        FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
    );
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pixel Store - Início</title>

    <!-- Arquivo responsável por toda a estilização -->
    <link rel="stylesheet" href="style.css?v=5">

</head>

<body>

<header>

    <h1>Pixel Store</h1>

    <nav>

        <a href="index.php">Início</a>

        <a href="#produtos">Produtos</a>

        <?php if (isset($_SESSION["usuario"])): ?>

            <!-- Links exibidos quando o usuário está logado -->
            <a href="produto.php">Cadastrar produto</a>

            <a href="sair.php">Sair</a>

        <?php else: ?>

            <!-- Links exibidos quando o usuário não está logado -->
            <a href="cadastro.php">Criar conta</a>

            <a href="login.php">Entrar</a>

        <?php endif; ?>

    </nav>

</header>

<div class="corte"></div>

<main>

    <!-- ==================================================
         ÁREA PRINCIPAL / HERO
         ================================================== -->

    <section class="hero">

        <div class="apresentacaoE">

            <span class="etiqueta">PIXEL STORE</span>

            <h2>Seu universo de tecnologia e jogos</h2>

            <p>
                Encontre acessórios, periféricos e produtos
                para deixar sua experiência ainda mais completa.
            </p>

            <p>
                Aqui você encontra tudo que um gamer precisa:
                headsets, teclados mecânicos, mouses de precisão,
                controles e acessórios para o seu setup.
            </p>

            <p>
                Trabalhamos com uma seleção de produtos pensada
                para quem joga de verdade, com qualidade e praticidade.
            </p>

            <a class="botao" href="#produtos">
                Ver produtos
            </a>

        </div>

        <div class="apresentacaoD">

            <img
                src="img\fotoinicio.jpg"
                alt="Produtos de tecnologia e jogos"
            >

        </div>

    </section>


    <!-- Mensagem mostrada quando o usuário está logado -->
    <?php if (isset($_SESSION["usuario"])): ?>

        <div class="usuarioLogado">

            Olá,
            <strong>
                <?= htmlspecialchars($_SESSION["usuario"]) ?>
            </strong>!

            Você está conectado.

        </div>

    <?php endif; ?>


    <!-- ==================================================
         PRODUTOS
         ================================================== -->

    <section id="produtos" class="secao">

        <h2>Destaques da semana</h2>

        <div class="produtos">

            <?php if (!empty($produtos)): ?>

                <?php foreach ($produtos as $produto): ?>

                    <?php

                    // Divide cada linha do arquivo pelo caractere |
                    $dados = explode("|", $produto);

                    // Se a linha estiver incompleta, pula para a próxima
                    if (count($dados) < 4) {
                        continue;
                    }

                    // Pega os dados do produto
                    $nome = htmlspecialchars(trim($dados[0]));

                    $precoBruto = trim($dados[1]);

                    $descricao = htmlspecialchars(trim($dados[2]));

                    $imagem = htmlspecialchars(
                        trim($dados[3]),
                        ENT_QUOTES,
                        'UTF-8'
                    );


                    // Converte o preço para o formato brasileiro
                    $precoNumero = str_replace(",", ".", $precoBruto);

                    if (is_numeric($precoNumero)) {

                        $preco = number_format(
                            (float)$precoNumero,
                            2,
                            ",",
                            "."
                        );

                    } else {

                        $preco = $precoBruto;

                    }

                    ?>

                    <!-- CARD DO PRODUTO -->

                    <article class="card">

                        <div class="imagemProduto">

                            <img
                                src="<?= $imagem ?>"
                                alt="<?= $nome ?>"
                            >

                        </div>

                        <div class="conteudoCard">

                            <h3>
                                <?= $nome ?>
                            </h3>

                            <p>
                                <?= $descricao ?>
                            </p>

                            <!-- Caixa que envolve o preço -->
                            <div class="precoProduto">

                                <span>Preço</span>

                                <strong>
                                    R$ <?= $preco ?>
                                </strong>

                            </div>

                            <!-- Botão de compra -->
                            <button
                                type="button"
                                class="botaoComprar"
                            >
                                Comprar
                            </button>

                        </div>

                    </article>

                <?php endforeach; ?>

            <?php else: ?>

                <!-- Aparece quando ainda não existe nenhum produto -->

                <div class="semProdutos">

                    <h3>Nenhum produto cadastrado</h3>

                    <p>
                        Entre no sistema para cadastrar
                        o primeiro produto.
                    </p>

                    <a class="botao" href="login.php">
                        Entrar
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </section>

</main>


<footer>

    <p>
        &copy; 2026 Pixel Store. Todos os direitos reservados.
    </p>

</footer>

</body>

</html>