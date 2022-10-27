<?php

/**
 * delete.php
 * Aplicativo que apaga um usuário específico do sistema.
 **/

/**
 * Importa as configurações e funções do aplicativo:
 * Referências: https://www.w3schools.com/php/php_includes.asp
 **/
require('includes/config.php');

/**
 * Declara / inicializa variável do aplicativo:
 * Neste caso, estamos criando um "menu principal" na variável $output que é 
 * usada no final do código, para exibir os resultados no navegador.
 **/
$output = '<a href="/readall.php">Listar</a> | <a href="/create.php">Cadastrar</a><hr>';

// Obtém o Id do usuário da URL:
$id = intval($_SERVER['QUERY_STRING']);

// Verifica de o Id obtido é um número:
if ($id == 0) :

    // Exibe mensagem de erro e encerra o programa:
    $output .= "<p>Oooops! Acesso inválido...";

else :

    // Query que obtém o usuário:
    $sql = "SELECT uid FROM users WHERE uid = '{$id}' AND ustatus != 'deleted';";

    // Executa query e armazena resultado em $res:
    $res = $conn->query($sql);

    // Verifica se usuário existe:
    if ($res->num_rows != 1) :

        // Usuário não existe, então gera erro e encerra:
        $output .= "<p>Oooops! Usuário não existe...";

    else :

        // Query que "apaga" o usuário:
        $sql = "UPDATE users SET ustatus = 'deleted' WHERE uid = '{$id}';";

        // Executa a query:
        $conn->query($sql);

        // Feedback:
        $output .= '<p>Oba! Usuário apagado com sucesso...';

    endif;

endif;

// Exibe as mensagens de saída e encerra o programa:
echo $output;
