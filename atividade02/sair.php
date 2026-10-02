<?php

// Inicia a sessão para podermos encerrá-la
session_start();


// Remove todos os dados armazenados na sessão
$_SESSION = [];


// Encerra a sessão
session_destroy();


// Depois de sair, volta para a página inicial
header("Location: index.php");

exit;

?>