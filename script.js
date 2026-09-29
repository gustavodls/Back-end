/* =====================================================
   BOAS-VINDAS
   ===================================================== */

function darBoasVindas() {

    const nome =
        document.getElementById("nomeVisitante").value.trim();

    const mensagem =
        document.getElementById("mensagemBoasVindas");


    if (nome === "") {

        mensagem.textContent =
            "Digite seu nome para entrar na loja.";

        return;
    }


    mensagem.textContent =
        "Seja bem-vindo à Pixel Store, " + nome + "!";

}



/* =====================================================
   ABRIR CADASTRO
   ===================================================== */

function abrirCadastro() {

    const cadastro =
        document.getElementById("cadastro");


    cadastro.classList.add("ativo");

}



/* =====================================================
   FECHAR CADASTRO
   ===================================================== */

function fecharCadastro() {

    const cadastro =
        document.getElementById("cadastro");


    cadastro.classList.remove("ativo");

}



/* =====================================================
   FECHAR CLICANDO FORA
   ===================================================== */

document.addEventListener("click", function(event) {

    const cadastro =
        document.getElementById("cadastro");


    if (!cadastro) {
        return;
    }


    if (
        event.target === cadastro
    ) {

        fecharCadastro();

    }

});