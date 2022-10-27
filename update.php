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

    /**
     * Detecta se o formulário foi enviado:
     **/
    if (isset($_POST['send'])) :

        // Pode atualizar:
        $sql = <<<SQL

SELECT uid FROM users
WHERE
    email = "{$_POST['atualemail']}"
    AND password = SHA1('{$_POST['password']}')
    AND ustatus != 'deleted';

SQL;

// Executa a query:
$res = $conn->query($sql);

        // Se não achou o usuário:
        if($res->num_rows != 1)
            die("<p>Oooops! Usuário não encontrado...");

        // Query que atualiza os dados do usuário:
        $sql = <<<SQL

UPDATE users SET
    name = '{$_POST['name']}',
    email = '{$_POST['email']}',
    photo = '{$_POST['photo']}',
    birth = '{$_POST['birth']}',
    bio = '{$_POST['bio']}'
WHERE 
    uid = '{$id}'
    AND password = SHA1('{$_POST['password']}')

SQL;

        // Executa a query:
        $conn->query($sql);

        // Feedback:
        $output .= "<p>Oba! usuário atualizado...";

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

<p>Altere apenas os campos necessários</p>

<form method="post" action="{$_SERVER['PHP_SELF']}?{$id}">
 
    <input type="hidden" name="send" value="ok">
    <input type="hidden" name="atualemail" value="{$user['email']}">
    <p>Nome: <input type="text" name="name" value="{$user['name']}"></p>
    <p>E-mail: <input type="text" name="email" value="{$user['email']}"></p>
    <p>Foto: <input type="text" name="photo" value="{$user['photo']}"></p>
    <p>Nacimento: <input type="date" name="birth" value="{$user['birth']}"></p>
    <p>Biografia: <textarea name="bio">{$user['bio']}</textarea></p>
    <hr>
    <p>Senha atual: <input type="text" name="password"></p>        
    <hr>    
    <p>
        <button type="submit">Salvar</button>
        &nbsp; &nbsp;
        <button type="reset">Limpar</button>
    </p>
    


</form>

HTML;

        endif;

    endif;

endif;

// Exibe as mensagens de saída e encerra o programa:
echo $output;
