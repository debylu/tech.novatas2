<?php

/**
 * read.php
 * Aplicativo que obtém todos os dados de um usuário específico, formata e 
 * exibe no documento.
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

    // Monta a query de consulta:
    $sql = <<<SQL

-- Obtém todos os campos com dados do usuário.
SELECT *,
    -- Formata a data de cadastro do usuário e envia como udatebr.
    DATE_FORMAT(udate, '%d/%m/%Y às %H:%i') AS udatebr,
    -- Formata a data de aniversário e envia como birthbr.
    DATE_FORMAT(birth, '%d/%m/%Y') AS birthbr,
    -- Formata a data do último login do usuário e envia como last_loginbr.
    DATE_FORMAT(last_login, '%d/%m/%Y às %H:%i') AS last_loginbr
FROM users
-- Filtra o usuário pelo ID...
WHERE uid = '{$id}'
    -- e, somente se o usuário não está apagado.
    AND ustatus != 'deleted';

SQL;

    // Executa a query e guarda os dados obtidos na variável $res:
    $res = $conn->query($sql);

    // Se não retornou um (e apenas um) usuário, exibe mensagem de erro:
    if ($res->num_rows != 1) :

        // Cria mensagem de erro:
        $output .= "<p>Oooops! Acesso inválido...";

    else :

        // Extrai os dados do usuário e guarda em $user:
        $user = $res->fetch_assoc();

        // Traduz o campo "type" para português e armazena em "$tipo":
        switch ($user['type']):

            case 'admin': // Traduz isso...
                $tipo = 'administrador'; // Para isso...
                break;

            case 'author': // Traduz isso...
                $tipo = 'autor'; // Para isso...
                break;

            case 'moderator':
                $tipo = 'moderador';
                break;

            case 'user':
                $tipo = 'usuário genérico';
                break;

        endswitch;

        // Tradus o status para português e armazena em $status:
        $status = $user['ustatus'];
        $from = array('online', 'offline', 'deleted', 'banned');
        $to = array('disponível', 'indisponível', 'apagado', 'banido');
        $status = str_replace($from, $to, $status);

        // Se o usuário nunca logou, ou seja, $user['last_login'] é vazio...
        if ($user['last_login'] == '') :

            // Exibe mensagem:
            $last_login = 'Nunca logou';

        // Se usuário já logou:
        else :

            // Exibe a data do último login, formatada:
            $last_login = $user['last_loginbr'];

        endif;

        // Se achou o usuário, exibe os dados dele:
        $output .= <<<HTML

<img src="{$user['photo']}" alt="{$user['name']}">
<h3>{$user['name']}</h3>
<ul>
    <li>Cadastrado em {$user['udatebr']}</li>
    <li>Email: {$user['email']}</li>
    <li>Nascimento: {$user['birthbr']}</li>
    <li>Tipo: {$tipo}</li>
    <li>Último login: {$last_login}</li>
    <li>Status atual: {$status}</li>
    <li>Sobre:<br>{$user['bio']}</li>
</ul>

<a href="update.php?{$user['uid']}">Editar</a> | <a href="delete.php?{$user['uid']}">Apagar</a>

HTML;

    endif;

endif;

// Exibe as mensagens de saída e encerra o programa:
echo $output;
