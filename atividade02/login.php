<?php

// Inicia a sessão
session_start();


// Se o usuário já estiver logado,
// não precisa acessar novamente o login
if (isset($_SESSION["usuario"])) {

    header("Location: produto.php");

    exit;
}


// Arquivo onde os usuários estão armazenados
$arquivoUsuarios = "usuarios.txt";


// Mensagem de erro
$mensagem = "";


// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebe usuário e senha
    $usuarioDigitado = trim($_POST["usuario"] ?? "");

    $senhaDigitada = $_POST["senha"] ?? "";


    // Inicialmente consideramos que o login está errado
    $loginCorreto = false;


    // Verifica se o arquivo existe
    if (file_exists($arquivoUsuarios)) {

        // Lê todos os usuários
        $usuarios = file(
            $arquivoUsuarios,
            FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
        );


        // Percorre todos os usuários
        foreach ($usuarios as $usuario) {

            // Separa os dados pelo |
            $dados = explode("|", $usuario);


            // Verifica se existem os três campos
            if (count($dados) >= 3) {

                $nome = trim($dados[0]);

                $usuarioArquivo = trim($dados[1]);

                $senhaArquivo = trim($dados[2]);


                // Compara usuário e senha digitados
                if (
                    $usuarioDigitado === $usuarioArquivo &&
                    $senhaDigitada === $senhaArquivo
                ) {

                    // Login encontrado
                    $loginCorreto = true;


                    // Guarda os dados na sessão
                    $_SESSION["usuario"] = $usuarioArquivo;

                    $_SESSION["nome"] = $nome;


                    break;
                }
            }
        }
    }


    // Se o login estiver correto,
    // manda o usuário para o cadastro de produtos
    if ($loginCorreto) {

        header("Location: produto.php");

        exit;

    } else {

        // Caso contrário, mostra mensagem de erro
        $mensagem = "Usuário ou senha incorretos.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Entrar - Pixel Store</title>

    <link rel="stylesheet" href="style.css?v=5">

</head>

<body>

<header>

    <h1>Pixel Store</h1>

    <nav>

        <a href="index.php">
            Início
        </a>

        <a href="cadastro.php">
            Criar conta
        </a>

    </nav>

</header>

<div class="corte"></div>


<main class="paginaFormulario">

    <section class="formularioContainer">

        <div class="iconeFormulario">
            🔐
        </div>

        <span class="etiquetaFormulario">
            PIXEL STORE
        </span>

        <h2>
            Entrar na loja
        </h2>

        <p class="subtituloFormulario">
            Acesse sua conta para cadastrar novos produtos.
        </p>


        <?php if ($mensagem !== ""): ?>

            <div class="mensagem erro">

                <?= htmlspecialchars($mensagem) ?>

            </div>

        <?php endif; ?>


        <form method="POST" action="login.php">

            <label for="usuario">
                Usuário
            </label>

            <input
                type="text"
                id="usuario"
                name="usuario"
                placeholder="Digite seu usuário"
                required
            >


            <label for="senha">
                Senha
            </label>

            <input
                type="password"
                id="senha"
                name="senha"
                placeholder="Digite sua senha"
                required
            >


            <button type="submit">
                Entrar
            </button>

        </form>


        <div class="separadorFormulario">
            <span>ou</span>
        </div>


        <p class="textoLink">

            Ainda não possui uma conta?

            <a href="cadastro.php">
                Cadastre-se
            </a>

        </p>


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