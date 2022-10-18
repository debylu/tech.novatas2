<?php

// Variáveis:
$cor_da_casa = 'red';
$Cor_da_casa = 'lilaz';
$casa_vendida = true;

// Constante:
define('NUMERO_DA_CASA', 25);

// Outra variável:
$corDaCasa = 'azul';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olá mundo!</title>
</head>

<body>

    <h1>Olá mundo do PHP!</h1>

    <?php echo 'Olá mundo!' ?>

    <?php

    // Comentário de uma linha

    /*
        Isso é um
        comentário com
        várias linhas.
    */
    echo 'Olá Terra!';
    echo "Olá Marte!";
    echo 'Olá Lua!'; // Exibe uma string
    echo 22.3; // Exibe um número
    echo false; // "Exibe" um booleano
    echo null; // "Exibe" um nullo
    ?>

    <hr>

    <?php

    if (false) {
        // Se acima for true
        echo 'A casa foi vendida.';
    } elseif (false) {
        // Se a primeira e false e esta for true
        echo 'Casa disponível';
    } else {
        // Se ambas forem, false
        echo 'Não sei ainda.';
    }
    // Acabou o if

    echo $cor_da_casa;

    echo NUMERO_DA_CASA;

    // Concatenação:
    echo '<p style="color: ' . $cor_da_casa . '">' . $cor_da_casa . '</p>';
    // <p style="color: purple">purple</p>

    // 
    echo "<h2>{$cor_da_casa}</h2>";
    echo '<h2>{$cor_da_casa}</h2>';

    // Caracter de escape "\"
    echo "<p style=\"color:red\">{$cor_da_casa}</p>";

    // Heredoc
    echo <<<SQL
<p style="color:red">{$cor_da_casa}</p> 
SQL;

    // Define uma função
    function soma($val1, $val2)
    {
        $resultado = $val1 + $val2;
        return $resultado;
    }

    // Invocar função
    echo soma(10, 5);

    ?>
    <hr>
    <?php echo soma(2, 50); ?>

</body>

</html>