<?php

//começo 1

    echo "olá mundo <br>";

//fim 1


// começo 2

    
    $nome = "Ana";
    $idade = 20;

    echo "$nome : $idade";

//fim 2
   

//começo 3


    $x = 3;
    $y = 10;
    $a = 4;
    $somam = $x + $y;

    echo " o resultado é: $somam";

    echo "<br>O resultado é: " . ($x + $y);

//fim 3


//começo 4 

    $n = 10;
    $nn = 10;

    $soma = ($n + $nn);
    $sub = ($n - $nn);
    $mul = ($n * $nn);
    $div = ($n / $nn);

    echo "<br> A soma é:$soma<br>";
    echo " A subtração é:$sub<br>";
    echo " A multiplicação é:$mul<br>";
    echo " A divisão é:$div<br>";


//fim 4 


//começo 5

    echo $x + 2 * $y / $a;

	$estado = "Minas Gerais";
	$cidade = "Uberlandia";
	$nomen = "<br>Gustavo";

	echo $nomen . "Mora em:" . $estado . "," . $cidade;

//fim 5


//começo 6

    $numero = 10;

    if ($numero > 0)
        {
        echo"<br> O numero é positivo<br>";
        }
    elseif ($numero < 0)
        {
        echo"O numero é negativo<br>";
        }

    else 
        {
        echo"Esse numero é igual a zero<br>";
        }

//fim 6


// começo 7 

$idade = 15;

if ($idade < 18)
    {
        echo " Vc é de Menor";
    }

else
    {
        echo "Vc é de Maior<br>";
    }
    
// fim 7

//começo 8 

$i = 0;

for ($i=1; $i <=10;  $i++)
    {
        echo "<br>$i";
    }

//fim 8

//começo 9

$numeron = 10;

while ($numeron >= 1)
    {
        echo "<br>$numeron";

        $numeron --;
    }

// fim 9

//começo 10

$nomes = ["gustavo","ana","paulo","josiel","rafael"];

    echo "<br>O primeiro nome é:" . $nomes[0];

    echo "<br>O ultimo nome é:" . $nomes[4];
   
//fim 10

//começo 11

$comidas = ["arroz","feijão","macarrão","carne","oleo"];

foreach ($comidas as $comidass)
    {
        echo"<br>$comidass";
    }

//fim 11

//começo 12

function dobros($numeroq)
    {
        return $numeroq * 2;
    }

    $valorOriginal = 10;

    $resultado = dobros($valorOriginal);

echo "<br>O dobro de $valorOriginal é $resultado!";

//fim 12

//começo 13

    $nota1 = 5;
    $nota2 = 7;
    $nota3 = 9;

    $media = ($nota1 + $nota2 + $nota3) /3;

    if ($media >=6)
        {
            echo"<br>Vc está acima da média";
        }
    else 
        {
            echo"Vc está a baixo da Média";
        }

//fim 13

//começo 14

$numerok = 7;
$ig = 1;

echo "Tabuada do $numerok:\n";

while ($ig <= 10) {
    $resultado = $numerok * $ig;
    echo "<br>$numerok x $ig = $resultado\n";
    $ig++;
}
//fim 14

// começo 15

$precosi = [19.90, 45.00, 89.99, 12.50, 150.00, 29.90];

$somaTotal = array_sum($precosi);

echo "<br>Soma total: R$ " . number_format($somaTotal, 2, ',', '.');

//fim 15

//começo 16

function maiorNumero($a, $b) {
    if ($a > $b) {
        return $a;
    } elseif ($b > $a) {
        return $b;
    } else {
        return "<br>Os valores são iguais.";
    }
}

echo maiorNumero(15, 8) . "\n";
echo maiorNumero(4, 20) . "\n";  
echo maiorNumero(10, 10) . "\n";

//fim 16


//começo 17

$nome_user = $_POST["nome"];
echo "<br>Bem vindo $nome_user";

//fim 17

//começo 18

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se os campos realmente existem na requisição antes de ler
    if (isset($_POST['num1'], $_POST['num2'], $_POST['operacao'])) {
        $num1 = (float) $_POST['num1'];
        $num2 = (float) $_POST['num2'];
        $operacao = $_POST['operacao'];
        $resultado = null;
        $simbolo = '';
        $erro = null;

        switch ($operacao) {
            case 'soma':
                $resultado = $num1 + $num2;
                $simbolo = '+';
                break;
            case 'subtracao':
                $resultado = $num1 - $num2;
                $simbolo = '-';
                break;
            case 'multiplicacao':
                $resultado = $num1 * $num2;
                $simbolo = '*';
                break;
            case 'divisao':
                if ($num2 != 0) {
                    $resultado = $num1 / $num2;
                    $simbolo = '/';
                } else {
                    $erro = "Não é possível dividir por zero!";
                }
                break;
            default:
                $erro = "Operação inválida.";
        }

        echo "<hr><h3>Resultado:</h3>";
        if ($erro) {
            echo "<p style='color: red;'>$erro</p>";
        } else {
            echo "<p>$num1 $simbolo $num2 = <strong>$resultado</strong></p>";
        }
    }
}

//fim 18

//começo 19

if(isset($_POST["anoNasc"], $_POST["nomePessoa"]))
    {
        $anoAtual = 2026;
        $anoNasc = $_POST["anoNasc"];
        $idaded = $anoAtual - $anoNasc;
        $nomePess = $_POST["nomePessoa"];

        if($idaded >= 18)
            {
                $maioridade = "maior";
            }
        else
            {
                $maioridade = "menor";
            }
        echo "ola" . $nomePess . "voce tem" . $idaded . "dito isso, vc é de" . $maioridade . ".";
    }

//fim 19

//começo 20

$listad = [
[
    "nome" => "arroz",
    "preço" =>10
],

[
    "nome" => "feijão",
    "preço" =>20
],

[
    "nome" => "carne",
    "preço" =>30
],

[
    "nome" => "batata",
    "preço" =>1
],

[
    "nome" => "cenoura",
    "preço" => 2
]
];

foreach($listad as $produtoe) {
    echo "<p>Produto" . $produtoe["nome"] . "custa R$" . $produtoe["preço"] . "</p>";
}

$totals = array_sum(array_column($listad,'preço'));
echo "Total: R$" . $totals;

echo "<br>";

$maiorj = max(array_column($listad, 'preço'));
echo "<br> Maior preço: R$" . $maiorj;

echo "<br>";

//fim 20


// salvar arquivo no txt
$arquivor = "arquivo.txt";

if (isset($_POST["nomer"]))
{
    $nomer = $_POST["nomer"];
    
    file_put_contents($arquivor, $nomer . PHP_EOL, FILE_APPEND);
}

//salvar arquivo no txt




	
	

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <!--atividade17-->

    <form method="POST">
        <label for="">Digite seu nome</label>
        <input name="nome">
        <button type="submit">clique</button>
    </form>

    <!--fim da 17-->


    <!--atividade18-->
    <form method="POST">
    <label for="num1">Número 1:</label>
        <input type="number" step="any" name="num1" id="num1" required>
        <br><br>

        <label for="operacao">Operação:</label>
        <select name="operacao" id="operacao" required>
            <option value="soma">+</option>
            <option value="subtracao">-</option>
            <option value="multiplicacao">*</option>
            <option value="divisao">/</option>
        </select>
        <br><br>

        <label for="num2">Número 2:</label>
        <input type="number" step="any" name="num2" id="num2" required>
        <br><br>

        <button type="submit">Calcular</button>

    </form>
    <!--fim da 18-->


     <!--salvar arquivo no txt-->
    <form method="POST">

        <label for="">salvar texto</label>
        <input name="nomer">

        <button type="submit">clique</button>
    <!--salvar arquivo no txt-->

    <!--pegar arquivo do txt e mostrar no site-->

    <div>
        <?php

            if(file_exists($arquivor))
                {
                    $nomer = file($arquivor);

                    foreach($nomer as $nomew)
                        {
                            echo "<p> Aluno: $nomew</p>";
                        }
                }

        ?>
    </div>
     <!--pegar arquivo do txt e mostrar no site-->



    </form>
    
</body>
</html>