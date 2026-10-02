<?php

// Arquivo onde os usuários serão armazenados
$arquivoUsuarios = "usuarios.txt";

// Variáveis utilizadas para mostrar mensagens na tela
$mensagem = "";
$tipoMensagem = "";


// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebe os dados enviados pelo formulário
    $nome = trim($_POST["nome"] ?? "");

    $usuario = trim($_POST["usuario"] ?? "");

    $senha = trim($_POST["senha"] ?? "");


    // Verifica se algum campo ficou vazio
    if ($nome === "" || $usuario === "" || $senha === "") {

        $mensagem = "Preencha todos os campos.";

        $tipoMensagem = "erro";

    } else {

        // Variável que informa se o usuário já existe
        $usuarioExiste = false;


        // Verifica se já existem usuários cadastrados
        if (file_exists($arquivoUsuarios)) {

            // Lê os usuários existentes
            $usuarios = file(
                $arquivoUsuarios,
                FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES
            );


            // Percorre todos os usuários
            foreach ($usuarios as $linha) {

                // Divide os dados pelo |
                $dados = explode("|", $linha);


                // Verifica se a linha possui os dados necessários
                if (count($dados) >= 3) {

                    // O segundo campo é o nome de usuário
                    if (trim($dados[1]) === $usuario) {

                        $usuarioExiste = true;

                        break;
                    }
                }
            }
        }


        // Se o usuário já existir, mostra erro
        if ($usuarioExiste) {

            $mensagem = "Esse usuário já está cadastrado.";

            $tipoMensagem = "erro";

        } else {

            /*
             * O caractere | é utilizado para separar os campos
             * dentro do arquivo TXT.
             *
             * Por isso removemos esse caractere dos dados.
             */

            $nome = str_replace(
                ["|", "\r", "\n"],
                "-",
                $nome
            );

            $usuario = str_replace(
                ["|", "\r", "\n"],
                "-",
                $usuario
            );

            $senha = str_replace(
                ["|", "\r", "\n"],
                "-",
                $senha
            );


            // Monta a linha que será salva no TXT
            $linha = $nome . "|" . $usuario . "|" . $senha;


            // Adiciona o novo usuário ao final do arquivo
            $resultado = file_put_contents(
                $arquivoUsuarios,
                $linha . PHP_EOL,
                FILE_APPEND
            );


            // Verifica se o cadastro foi salvo
            if ($resultado !== false) {

                $mensagem = "Cadastro realizado com sucesso!";

                $tipoMensagem = "sucesso";

            } else {

                $mensagem = "Erro ao salvar o cadastro.";

                $tipoMensagem = "erro";
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

    <title>Criar conta - Pixel Store</title>

    <link rel="stylesheet" href="style.css?v=5">

</head>

<body>

<header>

    <h1>Pixel Store</h1>

    <nav>

        <a href="index.php">Início</a>

        <a href="login.php">Entrar</a>

    </nav>

</header>

<div class="corte"></div>


<main class="paginaFormulario">

    <section class="formularioContainer">

        <div class="iconeFormulario">
            👤
        </div>

        <span class="etiquetaFormulario">
            PIXEL STORE
        </span>

        <h2>
            Criar sua conta
        </h2>

        <p class="subtituloFormulario">
            Cadastre-se para começar a utilizar a Pixel Store.
        </p>


        <?php if ($mensagem !== ""): ?>

            <div class="mensagem <?= $tipoMensagem ?>">

                <?= htmlspecialchars($mensagem) ?>

            </div>

        <?php endif; ?>


        <form method="POST" action="cadastro.php">

            <label for="nome">
                Nome
            </label>

            <input
                type="text"
                id="nome"
                name="nome"
                placeholder="Digite seu nome"
                required
            >


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
                Criar conta
            </button>

        </form>


        <div class="separadorFormulario">
            <span>ou</span>
        </div>


        <p class="textoLink">

            Já possui uma conta?

            <a href="login.php">
                Entrar
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